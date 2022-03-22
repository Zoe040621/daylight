<html>
<link rel="stylesheet" href="app.css">
    <form action="signHandler.php" method="post">
        <label for="head">Sign Up</label>
        <br><br>
        <label for="username">Username: </label>
        <input type="text" name="username">
        <br><br>
        <label for="email">Email: </label>
        <input type="email" name="email">
        <br><br>
        <label for="password">Password: </label>
        <input type="password" name="password">
        <br><br>
        <label for="confirm">Confirm Password: </label>
        <input type="password" name="confirm">
        <br><br>
        <input type="submit" name="submit" value="Sign Up">
    </form>
    Already have an account? 
    <a href="logIn.php">Log In</a><br><br>
</html>