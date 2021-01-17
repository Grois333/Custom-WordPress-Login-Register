<?php

require_once(realpath(dirname(__FILE__) . '/../../config.php'));

class User{


    function Dashboard(){
        if($this->Is_Login()){
            echo '  <div style="display:flex; flex-direction:column; align-items: center; margin-top: 50px;">
                    <h1>ברוך הבא ללוח המחוונים</h1> 
                    <a href="/loginregister/dashboard.php" style="font-size: 20px;">!יְצִיאָה</a> </div>';
        }else{
            echo 'Session Expired!';
        }
    }


    function generateCode($length=6){
        $chars = "abcd123456789";
        $code = "";
        $clean = strlen($chars) - 1;
        while (strlen($code) < $length){
            $code .= $chars[mt_rand(0, $clean)];
        }
        return $code;
    }


   


    // login validation
    function CheckLoginData($modalemail, $modalpassword){
        
        $db = new Connect;
        $result = '';
        if(isset($modalemail) && isset($modalpassword)){
            $modalemail = stripslashes(htmlspecialchars($modalemail));
            $modalpassword = stripslashes(htmlspecialchars(md5(md5(trim($modalpassword)))));
            if(empty($modalemail) or empty($modalpassword)){
                $result .= "<div class='error'><span></span><p><strong>ERROR:</strong> All fields are required!</p></div>";
            }else{
                $user = $db -> prepare("SELECT * FROM users WHERE email = :modalemail AND password = :modalpassword");
                $user->execute(array(
                    'modalemail' => $modalemail,
                    'modalpassword'  => $modalpassword
                ));
                $info = $user->fetch(PDO::FETCH_ASSOC);
                if ($user->rowCount() == 0){
                  
                    $result .= '<div class="error"><span></span><p><strong>ERROR:</strong> !ההתחברות נכשלה</p></div>';
                  
              
                }else{
                    $hash = $this->generateCode(10);
                    $upd = $db->prepare("UPDATE users SET session=:hash WHERE id=:ex_user");
                    $upd -> execute(array(
                        'hash' => $hash,
                        'ex_user' => $info['id']
                    ));
                    setcookie("id", $info['id'], time()+60*60*24*30, "/", NULL);
                    setcookie("sess", $hash, time()+60*60*24*30, "/", NULL);

                    echo ("<script>location.href = '/loginregister/?a=dashboard';</script>");
                }
            }
        }
        return $result;


    }



    // login form
    function LoginForm(){

        echo('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>');

        echo ("<script>$(document).ready(function() {window.$('#exampleModal').modal('show');})</script>");

 
        return '


        <div class=" form-container d-flex justify-content-center my-3 ">


        <!-- Form -->
        <form class="pull-right" onsubmit="submitForm();" action="?a=register" method="POST" ">

            <img src="assets/images/logo.png" alt="logo" class="mb-4">

            <h4 class="mb-4"><span style="color: #ff2b4f;">פרטי לקוח</span> > אפשרות משלוח > אמצעי תשלום</h4>

            <div class="mb-3 form-group info">
                <label for="" class="signIn-label">האם ברשותך חשבון באתר? <a href="" data-toggle="modal"
                        data-target="#exampleModal">התחבר/י
                        לחשבון</a></label>
                <label for="email" class="form-label">פרטי משתמש</label>

                <div class="palceholder text-end">
                    <label for="email">מייל</label>
                    <span class="star">*</span>
                </div>
                <input style="text-align: -webkit-right" type="email" class="form-control text-end" id="email" aria-describedby="emailHelp" name="email"
                    required>

            </div>

            <div class="pass">
                <div class="mb-3 form-group pass-container">

                    <div class="palceholder text-end confirm">
                        <label for="confirm">אימות סיסמה</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="password" name="confirm" class="form-control text-end" id="confirm" required>

                </div>

                <div class="mb-3 form-group pass-container">

                    <div class="palceholder text-end password">
                        <label for="password">בחר סיסמה</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="password" name="password" class="form-control text-end" id="password" required>

                </div>
            </div>

            <div class="mb-3 form-check">
                <input style="text-align: -webkit-right" type="checkbox" class="form-check-input" id="check1" required>
                <label class="form-check-label" for="check1">אני מאשר/ת קבלת פרסומים למייל</label>
            </div>



            <label for="" class="form-label mt-4 address-title">כתובת למשלוח</label>

            <div class="names">

                <div class="mb-3 form-group address name-container">

                    <div class="palceholder text-end lastname-placeholder">
                        <label for="lastname">שם משפחה</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="lastname" name="lastname" required>

                </div>


                <div class="mb-3 form-group address name-container">

                    <div class="palceholder text-end name-placeholder">
                        <label for="name">שם פרטי</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="name" name="name" required>

                </div>

            </div>


            <div class="house">

                <div class="mb-3 form-group address address-container">

                    <div class="palceholder text-end street-placeholder">
                        <label for="street">מס׳ בית</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="street" name="street" required>
                </div>

                <div class="mb-3 form-group address address-container">

                    <div class="palceholder text-end house-placeholder">
                        <label for="house">כתובת-רחוב, מס׳ בית, עיר</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="house" name="house" required>
                </div>

            </div>


            <div class="house2">

                <div class="mb-3 form-group address2 address2-container">

                    <div class="palceholder text-end inter-placeholder">
                        <label for="inter">קוד לבניין</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="inter" name="inter" required>
                </div>

                <div class="mb-3 form-group address2 address2-container">
                    <div class="palceholder text-end apt-placeholder">
                        <label for="apt">דירה / כניסה</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="apt" name="apt" required>
                </div>


                <div class="mb-3 form-group address2 address2-container">

                    <div class="palceholder text-end city-placeholder">
                        <label for="city">עיר</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="city" name="city" required>
                </div>


            </div>

            <div class="phone">

                <div class="mb-3 form-group address3 phone-container">

                    <div class="palceholder text-end phone-placeholder">
                        <label for="phone">טלפון</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="number" class="form-control tel text-end" id="phone" name="phone" required>
                </div>

            </div>

            <div class="action-container mt-3">
                <button id="submitBtn" type="submit" class="btn btn-primary">המשך לאפשרויות משלוח</button>
                <span id="status"></span>
                <a href="#">חזרה לעגלת הקניות ></a>
            </div>

         

        </form>
 

    </div>


        <!-- Modal -->
    <div class="modal fade" id="exampleModal">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">

                    <img src="assets/images/logo_yemini.png" alt="logo white">
                    <h5 class="modal-title">כיף לראות אותך שוב</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                ' .
                    ($_POST ? $this->CheckLoginData($_POST['modalemail'], $_POST['modalpassword']) : '')
                . '
            
                    <form class="pull-right" action="?a=login"  method="POST">

                        <div class="mb-3 form-group info">

                            <div class="palceholder text-end">
                                <label for="modalemail">מייל</label>
                                <span class="star">*</span>
                            </div>
                            <input type="email" class="form-control text-end" id="modalemail"
                                aria-describedby="emailHelp" name="modalemail" required>

                        </div>


                        <div class="mb-3 form-group pass-container">

                            <div class="palceholder text-end password">
                                <label for="modalpassword"> סיסמה</label>
                                <span class="star">*</span>
                            </div>
                            <input type="password" name="modalpassword" class="form-control text-end" id="modalpassword"
                                required>

                        </div>

                        <div class="action-container">
                            <a href="#">שכחתי סיסמה</a>
                            <button type="submit" id="modal-form" class="btn btn-primary mt-4">כניסה לחשבון</button>
                        </div>


                </div>

                </form>


            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

 
    
        ';

        

        
    }


     // register validation
     function CheckRegisterData(
        $email,
        $password,
        $confirm,
        $name,
        $lastname,
        $house,
        $street,
        $city,
        $apt,
        $inter,
        $phone

    ){
        $db = new Connect;
        $result = '';
        if(isset($email) && isset($password) && isset($confirm) && isset($name) && isset($lastname) && isset($house) && isset($street) && isset($city) && isset($apt) && isset($inter) && isset($phone)){
            $email = stripslashes(htmlspecialchars($email));
            $password = stripslashes(htmlspecialchars(md5(md5(trim($password)))));
            $confirm = stripslashes(htmlspecialchars(md5(md5(trim($confirm)))));
            $name = stripslashes(htmlspecialchars($name));
            $lastname = stripslashes(htmlspecialchars($lastname));
            $house = stripslashes(htmlspecialchars($house));
            $street = stripslashes(htmlspecialchars($street));
            $city = stripslashes(htmlspecialchars($city));
            $apt = stripslashes(htmlspecialchars($apt));
            $inter = stripslashes(htmlspecialchars($inter));
            $phone = stripslashes(htmlspecialchars($phone));
            if(empty($email) or empty($password) or empty($confirm) or empty($name) or empty($lastname) or empty($house) or empty($street) or empty($city) or empty($apt) or empty($inter) or empty($phone)){
                $result .= "<div class=\"error\"><p><strong>ERROR:</strong> All fields are required!</p></div>";
            }else if($password != $confirm){
                $result .= "<div class=\"error\"><p><strong>ERROR:</strong> !הסיסמאות שלך לא תואמות</p></div>";
            }else{

                $user = $db -> prepare("SELECT * FROM users WHERE email = :email");
                $user->execute(array(
                    'email' => $email,
                ));
                $info = $user->fetch(PDO::FETCH_ASSOC);
                if($user->rowCount() == 0){
                    $user = $db->prepare("INSERT INTO users (email, password, name, last_name, address, house_number, city, apt_number, intercom_code, phone) VALUES (:email, :password, :name, :last_name, :address, :house_number, :city, :apt_number, :intercom_code, :phone)");
                    $user -> execute(array(
                        'email' => $email,
                        'password' => $password,
                        'name' => $name,
                        'last_name' => $lastname,
                        'address' => $house,
                        'house_number' => $street,
                        'city' => $city,
                        'apt_number'=> $apt,
                        'intercom_code'=> $inter,
                        'phone'=> $phone
        
                    ));
                    if(!$user){
                        $result .= "<div class=\"error\"><p><strong>ERROR:</strong> All fields are required!</p></div>";
                    }else{
         

                        echo ("<script>location.href = '/loginregister/?a=login';</script>");

                    }
                }else{
                    $result .= '<div class="error"><span></span><p><strong>ERROR:</strong> !יש כבר משתמש עם דוא"ל זה</p></div>';
                }
            }
        }
        return $result;
    }


    // register form
    function RegisterForm(){
        return '
        <div class=" form-container d-flex justify-content-center my-3 ">

       
        <!-- Form -->
        <form class="pull-right" onsubmit="submitForm();" action="?a=register" method="POST" >

            <img src="assets/images/logo.png" alt="logo" class="mb-4">
    

            <h4 class="mb-4"><span style="color: #ff2b4f;">פרטי לקוח</span> > אפשרות משלוח > אמצעי תשלום</h4>

            ' .
            ($_POST ? $this->CheckRegisterData(
                $_POST['email'],
                $_POST['password'],
                $_POST['confirm'],
                $_POST['name'],
                $_POST['lastname'],
                $_POST['house'],
                $_POST['street'],
                $_POST['city'],
                $_POST['apt'],
                $_POST['inter'],
                $_POST['phone']
            
            ) : '')
            . '

            <div class="mb-3 form-group info">
                <label for="" class="signIn-label">האם ברשותך חשבון באתר? <a href="" data-toggle="modal"
                        data-target="#exampleModal">התחבר/י
                        לחשבון</a></label>
                <label for="email" class="form-label">פרטי משתמש</label>

                <div class="palceholder text-end">
                    <label for="email">מייל</label>
                    <span class="star">*</span>
                </div>
                <input style="text-align: -webkit-right" type="email" class="form-control text-end" id="email" aria-describedby="emailHelp" name="email"
                    required>

            </div>

            <div class="pass">
                <div class="mb-3 form-group pass-container">

                    <div class="palceholder text-end confirm">
                        <label for="confirm">אימות סיסמה</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="password" name="confirm" class="form-control text-end" id="confirm" required>

                </div>

                <div class="mb-3 form-group pass-container">

                    <div class="palceholder text-end password">
                        <label for="password">בחר סיסמה</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="password" name="password" class="form-control text-end" id="password" required>

                </div>
            </div>

            <div class="mb-3 form-check">
                <input style="text-align: -webkit-right" type="checkbox" class="form-check-input" id="check1" required>
                <label class="form-check-label" for="check1">אני מאשר/ת קבלת פרסומים למייל</label>
            </div>



            <label for="" class="form-label mt-4 address-title">כתובת למשלוח</label>

            <div class="names">

                <div class="mb-3 form-group address name-container">

                    <div class="palceholder text-end lastname-placeholder">
                        <label for="lastname">שם משפחה</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="lastname" name="lastname" required>

                </div>


                <div class="mb-3 form-group address name-container">

                    <div class="palceholder text-end name-placeholder">
                        <label for="name">שם פרטי</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="name" name="name" required>

                </div>

            </div>


            <div class="house">

                <div class="mb-3 form-group address address-container">

                    <div class="palceholder text-end street-placeholder">
                        <label for="street">מס׳ בית</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="street" name="street" required>
                </div>

                <div class="mb-3 form-group address address-container">

                    <div class="palceholder text-end house-placeholder">
                        <label for="house">כתובת-רחוב, מס׳ בית, עיר</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="house" name="house" required>
                </div>

            </div>


            <div class="house2">

                <div class="mb-3 form-group address2 address2-container">

                    <div class="palceholder text-end inter-placeholder">
                        <label for="inter">קוד לבניין</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="inter" name="inter" required>
                </div>

                <div class="mb-3 form-group address2 address2-container">
                    <div class="palceholder text-end apt-placeholder">
                        <label for="apt">דירה / כניסה</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="apt" name="apt" required>
                </div>


                <div class="mb-3 form-group address2 address2-container">

                    <div class="palceholder text-end city-placeholder">
                        <label for="city">עיר</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="text" class="form-control text-end" id="city" name="city" required>
                </div>


            </div>

            <div class="phone">

                <div class="mb-3 form-group address3 phone-container">

                    <div class="palceholder text-end phone-placeholder">
                        <label for="phone">טלפון</label>
                        <span class="star">*</span>
                    </div>
                    <input style="text-align: -webkit-right" type="number" class="form-control tel text-end" id="phone" name="phone" required>
                </div>

            </div>

            <div class="action-container mt-3">
                <button id="submitBtn" type="submit" class="btn btn-primary">המשך לאפשרויות משלוח</button>
                <span id="status"></span>
                <a href="#">חזרה לעגלת הקניות ></a>
            </div>

        </form>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">

                    <img src="assets/images/logo_yemini.png" alt="logo white">
                    <h5 class="modal-title">כיף לראות אותך שוב</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">
            
                    <form class="pull-right" action="?a=login"  method="POST">

                        <div class="mb-3 form-group info">

                            <div class="palceholder text-end">
                                <label for="modalemail">מייל</label>
                                <span class="star">*</span>
                            </div>
                            <input type="email" class="form-control text-end" id="modalemail"
                                aria-describedby="emailHelp" name="modalemail" required>

                        </div>


                        <div class="mb-3 form-group pass-container">

                            <div class="palceholder text-end password">
                                <label for="modalpassword"> סיסמה</label>
                                <span class="star">*</span>
                            </div>
                            <input type="password" name="modalpassword" class="form-control text-end" id="modalpassword"
                                required>

                        </div>

                        <div class="action-container">
                            <a href="#">שכחתי סיסמה</a>
                            <button type="submit" id="modal-form" class="btn btn-primary mt-4">כניסה לחשבון</button>
                        </div>


                </div>

                </form>


            </div>

        </div>
    </div>


        ';
    }





    function Is_Login(){
        $db = new Connect;
        if(isset($_COOKIE['id']) and isset($_COOKIE['sess'])){
            $id = intval($_COOKIE['id']);
            $userdata = $db -> prepare("SELECT id, session FROM users WHERE id=:id_user LIMIT 1");
            $userdata -> execute(array('id_user' => $id));
            $databaseData = $userdata->fetch(PDO::FETCH_ASSOC);
            if(($databaseData['session'] != $_COOKIE['sess']) or ($databaseData['id'] != intval($_COOKIE['id']))){
                setcookie('id', '', time() - 60*60*24*30, '/');
                setcookie('sess', '', time() - 60*60*24*30, '/');
                return FALSE;
            }else{
                return TRUE;
            }
        }else{
            return FALSE;
        }
    }

    
    }

