
<footer>
    <span>
        <a href="https://discord.gg/pripara" target="_blank"><i class="fa-brands fa-discord"></i></a>
        <a href="https://www.facebook.com/PriParaFansEsp" target="_blank"><i class="fa-brands fa-facebook"></i></a>
    </span>
    <span class="text-center mt-2"><i class="fa-solid fa-heart"></i> Made by Cindy ita with love for the fans</span>
    <span class="mt-1 d-flex flex-column flex-md-row">
        <a href="home">Home</a>
        <a href="termsandconditions">Terms and Conditions</a>
        <a href="privacypolicy">Privacy policy</a>
        <a href="cookies">Use of cookies</a>
        <a href="contact">Contact</a>
    </span>
    <span class="text-secondary mt-1">Beta v<?php echo VERSION; ?></span>
</footer>

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