<?php
session_start();
/**
 * Created by Andy Jeanes.
 * Date: 6/10/12
 * Time: 9:21 PM
 * To change this template use File | Settings | File Templates.
 */

if(isset($_POST['btnSubmit'])){
    $numberOfTextFields=$_POST['numberOfFields'];
    $_SESSION['numberOfTextFields']=$numberOfTextFields;
    $inputNumbers=array();
    $eligibleNumbers=array();
    $countNonZeroNumbers=0;

    for($i=0; $i<$numberOfTextFields; $i++){
        $currentValue=$_POST["number".$i];
        $inputNumbers[$i]= $currentValue;
        if($currentValue!="0" && $currentValue!=""){
            $eligibleNumbers[$countNonZeroNumbers]=$currentValue;
            $countNonZeroNumbers=$countNonZeroNumbers+1;
        }
    }
    $_SESSION['inputNumbers']= $inputNumbers;
    $_SESSION['countNonZeroNumbers']=$countNonZeroNumbers;

    $randomIndex=rand(0, $countNonZeroNumbers-1);
    $_SESSION['randomNumber']=$eligibleNumbers[$randomIndex];
}
?>
<html>
<head>
    <link type="text/css" href="style.css" rel="stylesheet"/>
    <script type="text/javascript">

        var numberOfTextFields=<?php if(isset($_SESSION['numberOfTextFields'])) echo  $_SESSION['numberOfTextFields']; else echo 6; ?>;
        var minNumber=0;
        var maxNumber=0;
        var numbers=Array();

        function showRandom(){
            numbers.splice(0,numbers.length);
            for(var i=1; i<=numberOfTextFields; i++){
                var element=document.getElementById("number"+i);
                if(element.value!="")
                    numbers.push(element.value);
            }

            var randNumber=Math.floor((Math.random()*numbers.length));
            alert(numbers[randNumber]);
        }

        function validateInput(){
            for(var i=0; i<numberOfTextFields; i++){
                var element=document.getElementById("number"+i);
                if(element.value!="" && isNaN(element.value)){
                    alert('The input should be a number');
                    element.focus();
                    return false;
                }

            }
        }

        function setData(){
            var element=document.getElementById("numberOfFields");
            element.value=numberOfTextFields;
        }

        function addFields(){
            numberOfTextFields=<?php if(isset($_SESSION['numberOfTextFields'])) echo  $_SESSION['numberOfTextFields']; else echo 6; ?>;
            var element=document.getElementById("newFields");
            if(element.value=="" || isNaN(element.value)){
                alert('The input should be a number');
                element.focus();
                return false;
            }
            else{
                var numberOfNewElements=parseInt(element.value,10);
                var newElements="";
                for(var i=0; i<numberOfNewElements; i++){
                    newElements=newElements+'<p><label for="number'+numberOfTextFields+'">Enter a number</label> <input id="number'+numberOfTextFields+'" name="number'+numberOfTextFields+'"  /></p>';
                    numberOfTextFields=numberOfTextFields+1;
                }
                document.getElementById("newElement").innerHTML= newElements;
            }
        }
    </script>

</head>
<body>

<div id="container">
    <div id="header">
        <h1>
            Decide O Tron
        </h1>

    </div>

    <div id="content">
        <form class="cmxform" id="numberform" method="post" action="index.php">
            <fieldset>
                <legend>Main Form</legend>
                <?php if (isset($_SESSION['numberOfTextFields'])) {
                     $inputNumbers=$_SESSION['inputNumbers'];
                     $numberOfTextFields=$_SESSION['numberOfTextFields'];
                     for($i=0; $i<$numberOfTextFields; $i++){
                         echo '<p>
                                <label for="number'.$i.'">Enter a number</label>
                                <input id="number'.$i.'" name="number'.$i.'" value="'.$inputNumbers[$i].'"  />
                               </p>';
                     }
                }
                else{
                ?>
                    <p>
                        <label for="number0">Enter a number</label>
                        <input id="number0" name="number0"  />
                    <p>
                    <p>
                        <label for="number1">Enter a number</label>
                        <input id="number1" name="number1"  />
                    <p>
                        <label for="number2">Enter a number</label>
                        <input id="number2" name="number2"  />
                    </p>
                    <p>
                        <label for="number3">Enter a number</label>
                        <input id="number3" name="number3"  />
                    </p>
                    <p>
                        <label for="number4">Enter a number</label>
                        <input id="number4" name="number4"  />
                    </p>
                    <p>
                        <label for="number5">Enter a number</label>
                        <input id="number5" name="number5"  />
                    </p>
                <?php } ?>
                <div id="newElement">

                </div>
                <p>
                   <input  type="submit" value="Decide" onclick="setData(); return validateInput();" name="btnSubmit" id="btnSubmit" />

                </p>
                <p>
                    Add <input id="newFields" name="newFields"  style="width: 40px" value="1" />  Boxes <input type="button" id="btnAdd" name="btnAdd" onclick="addFields()" value="Go" />
                </p>
            </fieldset>
            <input type="hidden" id="numberOfFields" name="numberOfFields">
        </form>

        <div id="randomResult">
            <?php
            if (isset( $_SESSION['randomNumber'])){
                echo "Your lucky number is : ". $_SESSION['randomNumber'];
            }
            ?>
        </div>
    </div>
    <div id="footer">
    </div>
</div>

 </body>
</html>
