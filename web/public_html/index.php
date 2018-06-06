<?php
//custom page info
$page_title = "Public Party Register Demo";
include("../php_includes/header.php");
include("../php_includes/call_api.php");

//requirements
//get states
$fcall = new call_api;
$states = $fcall->get_states();
?>

<!-- Join Form -->

<div class="container bigcont bpad">
    <div class="row">
        <h2>
            Join Test Political Party (TPP)<br /><br />
        </h2>
    
      <form action="./join.php" method="post" class="form-inline" name="join-party" id="join-party">
        <div class="form-group">  
    
         Names:  <input form="join-party" class="form-control" type="text" id="first_name" name="first_name" placeholder="First Name" required></input>
         <input form="join-party" class="form-control" type="text" id="middle_name" name="middle_name" placeholder="Middle Name"></input>
         <input form="join-party" class="form-control" type="text" id="surname" name="surname" placeholder="Surname" required></input><br /><br />
        Date of Birth: <select form="join-party" class="form-control" type="text" id="birth_month" name="birth_month" required>
                        <option disabled selected>Month</option>
                        <option value="January">January</option>
                        <option value="Febrary">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
            </select>
            <select form="join-party" class="form-control" type="text" id="birth_year" name="birth_year" required>
                <option disabled selected>Year</option>
                <?php
                date_default_timezone_set('Africa/Lagos');
                $year = date("Y");
                $year = $year - 15;
                $sdate = $year - 100;
                while ($sdate != $year) {
                    echo "<option value=\"$sdate\">$sdate</option>";
                    $sdate = $sdate+1;
                } 
                ?>
            </select>
        <br /> <br />
        

        
        Select Ward:
            <div id="state" class="form-control wheight">
            State: <select class="form-control" id="fstate" name="fstate" form="join-party" type="text" required onChange="get_lgas(this.value);">
                        <option disabled selected>Select state</option>
                        <?php
                        foreach($states as $x){
                            echo "<option value=\"$x\">$x</option>";
                        }
                        ?>
                    </select>
            </div>
            <div id="innerLGA" name="innerLGA" class="form-control wheight">
            LGA: <select  name="lga" form="join-party"> 

                    </select>
            </div>
            <div id="innerWard" class="form-control wheight">
            Ward: <select  name="ward" form="join-party">

                    </select>
            </div>
            <br /><br />

        
        Secret phrase:  <input form="join-party" class="form-control" type="password" id="sauce" name="sauce" placeholder="Secret" required></input> 
        <input form="join-party" class="form-control" type="password" id="sauce2" name="sauce2" placeholder="Repeat Secret" required oninput="check(this)"></input><br /> <br/>
        
        <div class="alert alert-warning" role="alert">
        Do not forget secret as it will not be saved anywhere and cannot be retrieved if lost.
        </div>
        <br /><br />

        Contact details:  <input form="join-party" class="form-control" type="email" id="email" name="email" placeholder="E-Mail Addresss"></input> 
        <input form="join-party" class="form-control" type="number" id="number" name="number" placeholder="Mobile Number"></input><br /> <br/>
        
        <br />

        <div id="ferror"></div><br />
        <div class="form-control checkbox">
            <label>
                <input type="checkbox" name="terms" required form="join-party"> I accept the terms and conditions. 
            </lable>
        </div> <br /><br />
        <button type="submit" id="submitbutton" class="btn btn-primary" form="join-party">Join</button>
      
        </div>
    </form>
    </div>
</div>


<?php 
include("../php_includes/footer.php");
?>