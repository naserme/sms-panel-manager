
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS داینامیک -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            transition: all 0.3s ease;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-bottom: 15px;
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body></body>
<div class="container">
    <h2>ورود با Secret Key</h2>

    <?php if(session('error')): ?>
        <div class="message"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <form action="<?php echo e(route('login')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <input type="text" name="secret_key" placeholder="Secret Key خود را وارد کنید" required>
        <button type="submit">ورود</button>
    </form>
</div>
</body>
</html>

<?php /**PATH D:\software\Installed\laragon\www\endpoint\resources\views/hi.blade.php ENDPATH**/ ?>