<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserOtpModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use Config\Email;

class LoginController extends Controller
{
    use ResponseTrait;

    private $session;

    function __construct()
    {
        helper(['html', 'http_response']);
        $this->session = session();
    }

    public function index()
    {
        return view('LoginView');
    }

    public function auth()
    {
        $userData = $this->authUser();

        if (!$userData) {
            return $this->failUnauthorized('Username atau password salah.');
        }

        $newOtpRequested = false;

        $isOtpRequired = $this->isOtpRequired($userData);

        if ($isOtpRequired) {
            if ($this->isNeedNewOTP($userData['username']) || $this->isOTPExpired($userData['last_request_otp'])) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return $this->fail("Akun yang Anda masukan tidak memiliki alamat e-mail yang valid. Silahkan hubungi IT.");
                }

                if (!$this->sendOTP($userData)) {
                    return $this->failServerError('Gagal saat mengirim OTP via e-mail.');
                }

                $newOtpRequested = true;

                $this->setSession($userData, true);
            }
        } else {
            $this->setSession($userData);

            $this->updateActivity($userData['id']);
        }

        $response = [
            'required' => $isOtpRequired,
            'requested' => $newOtpRequested,
            'sent_to' => $this->censorEmail($userData['email']),
            'last_request' => strtotime($userData['last_request_otp'] ?? date('Y-m-d H:i:s')),
        ];

        return $this->respond($response);
    }

    public function secondAuth()
    {
        // OTP Auth 
        $extConnection = new \App\Libraries\ExternalConnection();

        $payload = [
            'username' => $this->request->getPost('username'),
            'otp' => $this->request->getPost('otp'),
        ];

        $executeExtConnection = $extConnection->login('second-auth', $payload);

        $output = $extConnection->getResponse();

        if (!isset($output['results'])) {
            response($output['code'], $output['message']);
        }

        $result = $output['results'];

        // IP Checker
        $otpRequestedBy = $result['client_ip'];

        if ($otpRequestedBy != $this->request->getIPAddress()) {
            response(200, "Perubahan jaringan internet terdeteksi, silahkan refresh halaman ini");
        }

        // OTP Checker
        if ($this->isOTPExpired($result['created_at'])) {
            response(200, "OTP kadaluarsa");
        }

        $otpHashed = $result['otp'];
        $otpInput = $this->request->getPost('otp');

        if (!password_verify($otpInput, $otpHashed)) {
            response(200, "OTP yang dimasukan salah");
        }

        $this->updateActivity();

        $this->setSession();

        response(200, null);
    }

    public function resendOTP()
    {
        $result = $this->authUser(true);

        if (@$result['otp']) {
            if (!$this->sendOTP($result)) {
                response(500, "Gagal saat mengirim OTP. Silahkan dicoba kembali.");
            }

            $this->setSession($result, true);
        } else {
            response(500, "OTP baru tidak terkirim, silahkan dicoba kembali.");
        }

        response(200, null);
    }

    public function destroy()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }

    /**
     * Untuk authentikasi informasi login.
     * 
     * @param bool $generateNewOTP mau generate OTP baru atau ngga.
     * 
     * @return array|response
     */
    private function authUser(bool $generateNewOTP = false): false|array
    {
        // initial checking
        if (!$this->request->isAjax()) {
            log_message('alert', "[Login] Ada yang coba login pake CLI");
            return false;
        }

        if (!$this->request->getPost()) {
            log_message('alert', "[Login] Ada yang coba login tapi ga bawa payload");
            return false;
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        $userData = $userModel->getUser($username);

        if (!$userData) {
            return false;
        }

        if (!password_verify($password, $userData['password'])) {
            return false;
        }

        return $userData;
    }

    /**
     * Untuk generate random string sepanjang 6 karakter.
     * 
     * @return string
     */
    private function generateOTP(int $userId): string
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $requestedAt = date('Y-m-d H:i:s');

        (new UserOtpModel())->save([
            'ip' => $this->request->getIPAddress(),
            'otp' => $randomString,
            'requested_at' => $requestedAt,
            'requested_by' => $userId
        ]);

        (new UserModel())->update($userId, ['last_request_otp' => $lastRequest]);

        return $randomString;
    }

    /**
     * Untuk cek apakah hari ini sudah login dengan IP public yang sama.
     * 
     * @param array $data   data user
     * 
     * @return bool
     */
    private function isOtpRequired(array $data): bool
    {
        $clientIP = $this->request->getIPAddress();
        $lastLogin = $data['last_login'];
        $lastLoginIP = $data['last_login_ip'];

        if ($lastLoginIP == $clientIP && $lastLogin == date('Y-m-d')) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Untuk cek request OTP terakhir kurang dari 5 menit atau lebih.
     * 
     * @param string $lastRequest Terakhir kali request OTP kapan.
     * 
     * @return bool
     */
    private function isOTPExpired(string $lastRequest): bool
    {
        if (!$lastRequest) {
            return true;
        }

        $lastRequest = strtotime($lastRequest);
        $requestedAt = strtotime(date("Y-m-d H:i:s"));

        $minutesDiff = abs($lastRequest - $requestedAt) / 60;

        return $minutesDiff >= 5;
    }

    /**
     * Untuk cek apakah username yang sekarang diinput user sama dengan
     * username yang terakhir kali diinput dan manggil function isOTPExpired().
     * 
     * @param string $currentUsername   username yang diinput user saat ini.
     * @param string $otpLastRequest    Terakhir kali request OTP kapan.
     * 
     * @return bool
     */
    private function isNeedNewOTP(string $currentUsername, string $otpLastRequest = null): bool
    {
        $tempSession = $this->session->getTempdata();

        if (!$tempSession) {
            return true;
        }

        $lastInputClientIp = @$tempSession['temp_session_client_ip'];
        $currentClientIp = $this->request->getIPAddress();

        if ($currentClientIp != $lastInputClientIp) {
            return true;
        }

        $lastInputUsername = @$tempSession['temp_session_username'];

        if ($currentUsername != $lastInputUsername) {
            return true;
        }

        return false;
    }

    /**
     * Kirim OTP via e-mail.
     * 
     * @param array $data Berisi informasi yang dibutuhkan
     * 
     * @return bool
     */
    public function sendOTP(array $userData): bool
    {
        $otp = $this->generateOTP();

        $email = \Config\Services::email();
        $emailConfig = new Email();

        $email->setFrom($emailConfig->fromEmailOTP, $emailConfig->fromNameOTP)
            ->setTo($userData['email'])
            ->setReplyTo($emailConfig->itHelpdesk)
            ->setSubject("{$emailConfig->fromNameOTP} [$otp]");

        $detail = [
            'otp' => $otp,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'ip' => $this->request->getIPAddress(),
            'is_mobile' => $this->request->getUserAgent()->isMobile(),
            'jargon' => $emailConfig->jargon1,
        ];

        $email->setMessage(view('OTPEmailBody', $detail));

        return $email->send() ? true : false;
    }

    /**
     * Untuk sensor username pada email
     *
     * @param string $email
     * @return string
     */
    private function censorEmail(string $email): string
    {
        $email = explode('@', $email);
        $emailUsername = $email[0];
        $emailDomain = $email[1];

        $emailUsernameStart = substr($emailUsername, 0, 2);
        $emailUsernameEnd = substr($emailUsername, strlen($emailUsername) - 2, strlen($emailUsername));

        $emailUsernameMiddle = '';

        for ($i = 0; $i < 10; $i++) {
            $emailUsernameMiddle .= '*';
        }

        $emailUsername = $emailUsernameStart . $emailUsernameMiddle . $emailUsernameEnd;

        $cencoredEmail = "{$emailUsername}@{$emailDomain}";

        return $cencoredEmail;
    }

    /**
     * Untuk update aktifitas user (tanggal terakhir login dan 
     * IP terakhir yang dipakai).
     * 
     * @return bool
     */
    private function updateActivity(int $userId)
    {
        (new UserModel())->update(
            $userId,
            [
                'last_login' => date('Y-m-d H:i:s'),
                'last_login_ip' => $this->request->getIPAddress()
            ]
        );
    }

    /**
     * Untuk hapus session temporary, yang bertujuan agar sesudah
     * berhasil login, session temporary dihapus.
     */
    private function deleteTempSession()
    {
        $tempSession = $this->session->getTempdata();
        if ($tempSession) {
            foreach ($this->session->getTempdata() as $key => $value) {
                $this->session->removeTempdata($key);
            }
        }
    }

    /**
     * Untuk set session.
     * 
     * @param array $data   data user
     * @param bool $temp    mau di set temporary atau ngga
     * 
     */
    private function setSession($data = null, $temp = false)
    {
        if (!$temp) {
            if (is_array($data)) {
                $data['branch_code'] = strpos($data['branch_code'], ',') ? explode(',', $data['branch_code']) : $data['branch_code'];
                $data['branch_desc'] = strpos($data['branch_desc'], ',') ? explode(',', $data['branch_desc']) : $data['branch_desc'];
                $data['subbranch_code'] = strpos($data['subbranch_code'], ',') ? explode(',', $data['subbranch_code']) : $data['subbranch_code'];
                $data['subbranch_desc'] = strpos($data['subbranch_desc'], ',') ? explode(',', $data['subbranch_desc']) : $data['subbranch_desc'];
                $data['credential'] = strpos($data['credential'], ',') ? explode(',', $data['credential']) : $data['credential'];
                $data['server_name'] = strpos($data['server_name'], ',') ? explode(',', $data['server_name']) : $data['server_name'];

                $sessionData = [
                    'user_id' => $data['user_id'],
                    'entity_code' => $data['entity_code'],
                    'entity_desc' => $data['entity_desc'],
                    'branch_code' => $data['branch_code'],
                    'branch_desc' => $data['branch_desc'],
                    'subbranch_code' => $data['subbranch_code'],
                    'subbranch_desc' => $data['subbranch_desc'],
                    'credential' => $data['credential'],
                    'server_name' => $data['server_name'],
                    'username' => $data['username'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'nik' => $data['nik'],
                    'person_type' => $data['person_type']
                ];
            } else {
                $tempSession = $this->session->getTempdata();

                $tempSession['temp_session_branch'] = strpos($tempSession['temp_session_branch'], ',') ? explode(',', $tempSession['temp_session_branch']) : $tempSession['temp_session_branch'];
                $tempSession['temp_session_branch_desc'] = strpos($tempSession['temp_session_branch_desc'], ',') ? explode(',', $tempSession['temp_session_branch_desc']) : $tempSession['temp_session_branch_desc'];
                $tempSession['temp_session_subbranch'] = strpos($tempSession['temp_session_subbranch'], ',') ? explode(',', $tempSession['temp_session_subbranch']) : $tempSession['temp_session_subbranch'];
                $tempSession['temp_session_subbranch_desc'] = strpos($tempSession['temp_session_subbranch_desc'], ',') ? explode(',', $tempSession['temp_session_subbranch_desc']) : $tempSession['temp_session_subbranch_desc'];
                $tempSession['temp_session_credential'] = strpos($tempSession['temp_session_credential'], ',') ? explode(',', $tempSession['temp_session_credential']) : $tempSession['temp_session_credential'];
                $tempSession['temp_session_server_name'] = strpos($tempSession['temp_session_server_name'], ',') ? explode(',', $tempSession['temp_session_server_name']) : $tempSession['temp_session_server_name'];

                $sessionData = [
                    'user_id' => (int) $tempSession['temp_session_user_id'],
                    'entity_code' => $tempSession['temp_session_entity'],
                    'entity_desc' => $tempSession['temp_session_entity_desc'],
                    'branch_code' => $tempSession['temp_session_branch'],
                    'branch_desc' => $tempSession['temp_session_branch_desc'],
                    'subbranch_code' => $tempSession['temp_session_subbranch'],
                    'subbranch_desc' => $tempSession['temp_session_subbranch_desc'],
                    'credential' => $tempSession['temp_session_credential'],
                    'server_name' => $tempSession['temp_session_server_name'],
                    'username' => $tempSession['temp_session_username'],
                    'name' => $tempSession['temp_session_name'],
                    'email' => $tempSession['temp_session_email'],
                    'nik' => $tempSession['temp_session_nik'],
                    'person_type' => $tempSession['temp_session_person_type']

                ];
            }

            $this->deleteTempSession();

            $this->session->set($sessionData);
        } else {
            $this->deleteTempSession();

            $this->session->setTempdata([
                'temp_session_user_id' => (string) $data['user_id'],
                'temp_session_entity' => $data['entity_code'],
                'temp_session_entity_desc' => $data['entity_desc'],
                'temp_session_branch' => $data['branch_code'],
                'temp_session_branch_desc' => $data['branch_desc'],
                'temp_session_subbranch' => $data['subbranch_code'],
                'temp_session_subbranch_desc' => $data['subbranch_desc'],
                'temp_session_credential' => $data['credential'],
                'temp_session_server_name' => $data['server_name'],
                'temp_session_username' => $data['username'],
                'temp_session_name' => $data['name'],
                'temp_session_email' => $data['email'],
                'temp_session_nik' => $data['nik'],
                'temp_session_person_type' => $data['person_type'] ?? '-',
                'temp_session_client_ip' => $this->request->getIPAddress(),
                'otp_last_request' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
