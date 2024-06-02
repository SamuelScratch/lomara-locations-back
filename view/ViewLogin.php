<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> Connexion Admin </title>  
  
</head>    
<body>  
    <div style="margin:100px auto;display:flex;flex-direction:column;align-items:center">
    <h1> Connexion Administrateur </h1>   
    <form action="/admin" method="post">  
        <div class="container">   
            <label>Identifiant : </label>   
            <input type="text" placeholder="Identifiant" name="username" required>  
            <br><br>
            <label>Password : </label>   
            <input type="password" placeholder="Mot de passe" name="password">  
            <br><br>
            <button type="submit">Login</button>   
            <br>
            <div style="color:red">
                <?php if(isset($mess_err)) { echo $mess_err; } ?>  
            </div>
        </div>   
    </form> 
    </div>    
</body>     
</html> 