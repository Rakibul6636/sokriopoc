<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 30px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #3498db;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #2980b9;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="registerForm" method="POST" action="{{ route('register') }}">
            <input type="text" id="name" name="name" placeholder="name" required>
            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Password_confirmation" required>

            <button type="submit">Register</button>
        </form>
    </div>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password').value;

            // Make a request to register and get the token
            register(name,email, password,password_confirmation);
        });

        async function register(name, email, password,password_confirmation) {
            try {
                const response = await axios.post('{{ route('register') }}', {
                    name:name,
                    email: email,
                    password: password,
                    password_confirmation: password_confirmation
                });
                const token = response.data.data.token;

                // Store the token in local storage
                localStorage.setItem('token', token);

                console.log('Token:', token);

                // Redirect to another page or trigger another action
                window.location.href = 'productsShow';
            } catch (error) {
                console.log('Login error:', error.response.data);
            }
        }
    </script>

</body>
</html>
