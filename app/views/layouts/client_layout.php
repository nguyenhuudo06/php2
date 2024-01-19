<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($sub_content['title']) ? $sub_content['title'] : '' ?></title>
    
</head>
<body>
    <p>Header</p>


<?php
    $this->render($content);
?>

    <p>Footer</p>

    <script src="<?php echo _WEB_ROOT_ ?>/public\assets\client\js\1.js"></script>
</body>
</html>
