<?php

class UserAPI {
    private $usersFile = 'users.json';

    public function authenticateUser($username, $password) {
        $users = $this->getUsers();
        foreach ($users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                 return ['message' => 'User authentication'];
            }
        }
        return null;
    }

    private function getUsers() {
        if (!file_exists($this->usersFile)) {
            return [];
        }
        $usersData = file_get_contents($this->usersFile);
        return json_decode($usersData, true);
    }
}

// Проверка запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    if (isset($requestData['username']) && isset($requestData['password'])) {
        $userAPI = new UserAPI();
        $response = $userAPI->authenticateUser($requestData['username'], $requestData['password']);
        if ($response !== null) {
            echo json_encode($response);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Authentication failed']);
        }
    } else {
        http_response_code(400); // Bad request
        echo json_encode(['error' => 'Username and password are required']);
    }
} else {
    http_response_code(405); // Method not allowed
    echo json_encode(['error' => 'Only POST method is allowed']);
}
?>
