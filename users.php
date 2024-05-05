<?php

class UserAPI {
    private $usersFile = 'users.json';

    public function handleRequest($method, $data = []) {
        switch ($method) {
            case 'POST':
                return $this->createUser($_POST);
            case 'PUT':
                parse_str(file_get_contents('php://input'), $putData);
                return $this->updateUser($data['id'], $putData);
            case 'DELETE':
                return $this->deleteUser($data['id']);
            case 'GET':
                return $this->getUser($data['id']);
            default:
                return ['error' => 'Unsupported HTTP method'];
        }
    }

    private function createUser($userData) {
        $users = $this->getUsers();
        $users[] = $userData;
        $this->saveUsers($users);
        return ['message' => 'User created successfully'];
    }

    private function updateUser($userId, $newData) {
        $users = $this->getUsers();
        foreach ($users as &$user) {
            if ($user['id'] === $userId) {
                $user = array_merge($user, $newData);
                $this->saveUsers($users);
                return ['message' => 'User updated successfully'];
            }
        }
        return ['error' => 'User not found'];
    }

    private function deleteUser($userId) {
        $users = $this->getUsers();
        foreach ($users as $key => $user) {
            if ($user['id'] === $userId) {
                unset($users[$key]);
                $this->saveUsers($users);
                return ['message' => 'User deleted successfully'];
            }
        }
        return ['error' => 'User not found'];
    }

    private function getUser($userId) {
        $users = $this->getUsers();
        foreach ($users as $user) {
            if ($user['id'] === $userId) {
                return $user;
            }
        }
        return ['error' => 'User not found'];
    }

    private function getUsers() {
        if (!file_exists($this->usersFile)) {
            return [];
        }
        $usersData = file_get_contents($this->usersFile);
        return json_decode($usersData, true);
    }

    private function saveUsers($users) {
        file_put_contents($this->usersFile, json_encode($users));
    }
}

// Проверка запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAPI = new UserAPI();
    $response = $userAPI->handleRequest('POST');
    echo json_encode($response);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $putData);
    $userId = isset($_GET['id']) ? $_GET['id'] : null;
    $putData['id'] = $userId;
    $userAPI = new UserAPI();
    $response = $userAPI->handleRequest('PUT', $putData);
    echo json_encode($response);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $userId = isset($_GET['id']) ? $_GET['id'] : null;
    $userAPI = new UserAPI();
    $response = $userAPI->handleRequest('DELETE', ['id' => $userId]);
    echo json_encode($response);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = isset($_GET['id']) ? $_GET['id'] : null;
    $userAPI = new UserAPI();
    $response = $userAPI->handleRequest('GET', ['id' => $userId]);
    echo json_encode($response);
} else {
    http_response_code(405); // Метод не разрешен
}
?>
