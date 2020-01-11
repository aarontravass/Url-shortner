<!DOCTYPE html>
<head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style>
    .form-control{
            width:100%;
            display:block;
    }
    .container{
        margin-top: 10%;
    }
    .headg{
        font-size: 200%;
    }
    .boxy{
            border:1px solid black;
            width:50%;
            display:block;
    }
</style>
</head>
<body>
    <div class="container">
        <p class="headg text-center">Url Shortner</p>
    </div>
    <div class="container">
        <form action="" method="POST">
            <div class="form-group">
                <input class="form-control" type="url" name="url" pattern="\S+" placeholder="Enter your url here..." required>
            </div>
            <div class="form-group text-center">
                <input class="btn btn-primary" type="submit" name="submit" value="Get Code!">
            </div>
        </form>
</div>
    <?php

        function getchoice(){
            $ch[0]=rand(0,1);
            $ch[1]=rand(0,1);
            $ch[2]=rand(0,1);
            $ch[3]=rand(0,1);
            $ch[4]=rand(0,1);
            return $ch;

        }
        function getcde(){
            $s="abcdefghijklmnopqrstuvwxyz";
            #$s=str_split($s);
            $choice_list=getchoice();
            $code=$s[rand(0,strlen($s)-1)];
            for($i=0;$i<5;$i++){
                if($choice_list[$i]==0){
                    $code=$code.$s[rand(0,strlen($s)-1)];
                }
                else{
                    $code=$code.strval(rand(0,9));
                }
            }
            return $code;
        }

        function insertaddress($address){
            try{
                $servername = "";
                $username = "";
                $password = "";
                $dbname="urls";
                $conn = mysqli_connect($servername, $username, $password,$dbname);
                while(TRUE){
                    $c=getcde();
                    $sql="select * from url where code = '".$c."';";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)==0){
                        $sql="insert into url values(null,'".$c."','".$address."');";
                        
                        $result=mysqli_query($conn,$sql);
                        mysqli_close($conn);
                        return $c;
                        break;
                    }
                }
            }
            catch(Exception $e){
                echo $e;
            }
        }

        


        
        function getaddress($code){
            try{
                $servername = "";
                $username = "";
                $password = "";
                $dbname="urls";
                $conn = mysqli_connect($servername, $username, $password,$dbname);
                
                
                
                $sql="select * from url where code = '".$code."';";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_array($result);
                if(count($row)==0){
                    return 0;
                }
                mysqli_close($conn);
                return $row['address'];

                    
            
            }
            catch(Exception $e){
                echo $e;
            }
        }

        


        if(isset($_POST['submit'])){
            $url=$_POST['url'];
            $read=insertaddress($url);
            $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?q=".$read;
            echo "<div class='boxy container'>";
            echo "<br>";
            echo "<p class='text-center'>Your Link is</p>";
            echo "<div class='text-center'>";
            echo "<a class='nav-link' id='mylink' href='".$link."'>".$link."</a>";
            echo "</div>";
            echo "<br>";
            echo "</div>";
            echo "<br><br>";


        }
        if(isset($_GET['q'])){
            
            $c=$_GET['q'];
            $address=getaddress($c);
            header('Location: '.$address);
        
        
        }


    ?>
    



</body>
</html>