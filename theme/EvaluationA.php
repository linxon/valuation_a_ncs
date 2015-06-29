<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Evaluation Assignment – Nested comment system</title>
        <link href="assets/template.css" rel="stylesheet" type="text/css"/>
        <script src="assets/jquery.min.js" type="text/javascript"></script>
        <script src="assets/main.js" type="text/javascript"></script>
        <script src="assets/comment.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="page-border"></div>
        <div id="wrapper">
            <?php if(file_exists($view_file) and is_readable($view_file)) : ?>
                <?php require($view_file); ?>
            <?php endif; ?>
        </div>
    </body>
</html>
