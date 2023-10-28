
</div>  <!-----CLOSE CONTENT PAGE------>
<script src="./assets/js/app.js?version=<?php echo VERSION; ?>"></script>
<script src="./assets/js/datatable.js?version=<?php echo VERSION; ?>"></script>
<?php 
    if($scripts){
        foreach ($scripts as $value) {
            echo '<script src="'.$value.'?version='.VERSION.'"></script>';
        }
    }
?>
</body>
</html>