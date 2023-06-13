<?php

// Please add your logic here

echo "<h1 class='starting-title'>Nice to see you! &#128075;</h1>";


$jsonData = file_get_contents('dataset/users.json');


$users = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $userId = $_POST['delete'];
    
 
    $userIndex = null;
    foreach ($users as $index => $user) {
        if ($user['id'] == $userId) {
            $userIndex = $index;
            break;
        }
    }


    if ($userIndex !== null) {
        array_splice($users, $userIndex, 1);
        
     
        file_put_contents('dataset/users.json', json_encode($users, JSON_PRETTY_PRINT));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];

    $newUserId = count($users) + 1;

    $newUser = [
        'id' => $newUserId,
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'address' => [
            'street' => $street,
            'city' => $city,
            'zipcode' => $zipcode,
        ],
        'phone' => $phone,
        'company' => [
            'name' => $company,
        ],
    ];

    $users[] = $newUser;

    file_put_contents('dataset/users.json', json_encode($users, JSON_PRETTY_PRINT));
}

echo "<table>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Username</th>";
echo "<th>Email</th>";
echo "<th>Address</th>";
echo "<th>Phone</th>";
echo "<th>Company</th>";
echo "<th>Actions</th>"; 
echo "</tr>";

if ($users !== null) {
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['name'] . "</td>";
        echo "<td>" . $user['username'] . "</td>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td>" . $user['address']['street'] . ", " . $user['address']['zipcode'] . " " . $user['address']['city'] . "</td>";
        echo "<td>" . $user['phone'] . "</td>";
        echo "<td>" . $user['company']['name'] . "</td>";
        echo "<td>
        <form method='POST' onsubmit=\"return confirm('Are you sure you want to delete this user?');\">
            <input type='hidden' name='delete' value='" . $user['id'] . "'>
            <button class='remove-button' type='submit'>Remove</button>
        </form>
      </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No data available</td></tr>";
}

echo "</table>";

echo "<h1 class='starting-title'>Add new user</h1>";

echo "<form class='new-user' method='POST'>";
echo "<label for='name'>Name:</label>";
echo "<input type='text' name='name' id='name' required><br>";
echo "<label for='username'>Username:</label>";
echo "<input type='text' name='username' id='username' required><br>";
echo "<label for='email'>Email:</label>";
echo "<input type='email' name='email' id='email' required><br>";
echo "<label for='street'>Street:</label>";
echo "<input type='text' name='street' id='street' required><br>";
echo "<label for='city'>City:</label>";
echo "<input type='text' name='city' id='city' required><br>";
echo "<label for='zipcode'>Zipcode:</label>";
echo "<input type='text' name='zipcode' id='zipcode' required><br>";
echo "<label for='phone'>Phone:</label>";
echo "<input type='text' name='phone' id='phone' required><br>";
echo "<label for='company'>Company:</label>";
echo "<input type='text' name='company' id='company' required><br>";
echo "<button class='submit-button' type='submit' name='submit'>Submit</button>";
echo "</form>";

