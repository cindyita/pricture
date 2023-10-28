
<script src="./assets/library/bootstrap5/bootstrap.bundle.min.js"></script>
<!----------------------------------->
<script src="./assets/js/app.js?version=<?php echo VERSION; ?>"></script>
<?php 
    if($scripts){
        foreach ($scripts as $value) {
            echo '<script src="'.$value.'?version='.VERSION.'"></script>';
        }
    }
?>
</body>
</html>