<?php

// TASK REQUIREMENTS

// collect the user data from the form, store it in variables       [X]
//  validate the post data                                          [X]
// if valid, POST-red-GET to location                               [X]
// make sure its responsive to size                                 [X]
// make sure its safe from HTML injection                           [X]
// when valid, send post Data to provided email                     [X]


// ############################################## MODEL ######################################################

session_start();

// ------------------------------------------------------------------------------------------------------|
//                                                                                                       |
//                                               CHECKS                                                  |
//                                                                                                       |
//                                                                                                       |

if (isset($_POST['submitON'])) {

  // lets put the data in variables and then lets validate them
  // we also make sure to avoid html injection
  $fName = htmlentities($_POST['fName']);
  $lName = htmlentities($_POST['lName']);
  $emAddress = htmlentities($_POST['emailAddress']);
  $tNumb = htmlentities($_POST['tNumb']);
  $addI = htmlentities($_POST['addr1']);
  $addII = htmlentities($_POST['addr2']);
  $town = htmlentities($_POST['town']);

  $county = htmlentities($_POST['county']);
  $postCode = htmlentities($_POST['postCode']);
  $country = htmlentities($_POST['country']);
  $desc = htmlentities($_POST['desc']);

  // all fields arent empty
  $fieldsNonEmpty = false;
  $fieldsNonEmptyII = false;

  // FIRST SET OF FIELDS
  if ((strlen($fName) < 1) || (strlen($lName) < 1) || (strlen($emAddress) < 1) || (strlen($tNumb) < 1) || (strlen($addI) < 1) || (strlen($town) < 1)) {
    $fieldsNonEmpty = false;
  } else {
    $fieldsNonEmpty = true;
  }

  // SECOND SET OF FIELDS
  if ((strlen($county) < 1) || (strlen($postCode) < 1) || (strlen($country) < 1) || (strlen($desc) < 1)) {
    $fieldsNonEmptyII = false;
  } else {
    $fieldsNonEmptyII = true;
  }

  // check email validity
  $emailCheck = false;

  if (strpos($emAddress, '@') == false) {
    $emailCheck = false;
  } else {
    $emailCheck = true;
  }

  // telephone check
  $telCheck = false;

  if (is_numeric($tNumb) == false) {
    $telCheck = false;
  } else {
    $telCheck = true;
  }

//                                                                                                       |
//                                               CHECKS                                                  |
//                                                                                                       |
//                                                                                                       |
// ------------------------------------------------------------------------------------------------------|

// ------------------------------------------------------------------------------------------------------|
//                                                                                                       |
//                                               VALIDATION                                              |
//                                                                                                       |
//                                                                                                       |

  // validation starts
  if ($fieldsNonEmpty == false || $fieldsNonEmptyII == false) {

    $_SESSION['error'] = 'ALL FIELDS ARE REQUIRED!';
    $_SESSION['errorII'] = 'ALL FIELDS ARE REQUIRED!';

  } elseif ($emailCheck == false) {

    $_SESSION['error'] = 'EMAIL IS NOT VALID!';
    $_SESSION['errorII'] = 'EMAIL IS NOT VALID!';


  } elseif ($telCheck == false) {

    $_SESSION['error'] = 'PHONE NUMBER IS NOT VALID!';
    $_SESSION['errorII'] = 'PHONE NUMBER IS NOT VALID!';

  } else {

    // move the variables to session ones
    $_SESSION['fname'] = $fName;
    $_SESSION['lname'] = $lName;
    $_SESSION['emaddress'] = $emAddress;
    $_SESSION['tnumb'] = $tNumb;
    $_SESSION['addI'] = $addI;
    $_SESSION['addII'] = $addII;
    $_SESSION['town'] = $town;
    $_SESSION['county'] = $county;
    $_SESSION['postCode'] = $postCode;
    $_SESSION['country'] = $country;
    $_SESSION['desc'] = $desc;

    // prepare var for quick insert inside email
    $first_nameSes = $_SESSION['fname'];
    $last_nameSes = $_SESSION['lname'];
    $email_addressSes = $_SESSION['emaddress'];
    $telNumbSes = $_SESSION['tnumb'];
    $address1Ses = $_SESSION['addI'];
    $address2Ses = $_SESSION['addII'];
    $townSes = $_SESSION['town'];
    $countySes = $_SESSION['county'];
    $postCodeSes = $_SESSION['postCode'];
    $countrySes = $_SESSION['country'];
    $descSes = $_SESSION['desc'];

    $file = $_POST['fileToSend'];

    $partI = "Full Name: " . $first_nameSes . " " . $last_nameSes . "\n\n" . "Email: " . $email_addressSes . "\n\n" . "Telephone Number: " . $telNumbSes . "\n\n" . "Address 1: " . $address1Ses . "\n\n" . "Address 2: " . $address2Ses;

    $partII = "Town: " . $townSes . "\n\n" . "County: " . $countySes . "\n\n" . "Postcode: " . $postCodeSes . "\n\n" . "Country: " . $countrySes . "\n\n" . "Description: " . $descSes . "\n\n" . $file;


    $to = $email_addressSes;
    $subject = "Form submission";
    $message = $partI . "\n\n" . $partII;
    $headers = "From: email@outlook.com";

    mail($to, $subject, $message, $headers);

    header('Location: index.php');

  }

//                                                                                                       |
//                                               VALIDATION                                              |
//                                                                                                       |
//                                                                                                       |
// ------------------------------------------------------------------------------------------------------|

}

// ############################################## MODEL ######################################################

// ############################################### #### ######################################################

// ############################################### VIEW ######################################################
 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Real Response Media Task</title>
    <link rel="stylesheet" href="CSS/styling.css">
  </head>
  <body>

    <form action="index.php" method="post">

      <?php
      // here we set the success / error flash message
      if (isset($_SESSION["error"])) {
        echo('<p id="errorMessage" style = "color:red">').htmlentities($_SESSION["error"])."</p>\n";
        unset($_SESSION["error"]);
      }
      ?>


      <div class="cells">
        <label class="label" style="height:30px" for="">First Name</label> <br> <br>
        <input class="input" type="text" name="fName" value="" size="35">
      </div>

      <div class="cells">
        <label class="label" for="">Last Name</label>  <br> <br>
        <input class="input" type="text" name="lName" value="" size="35">
      </div>


      <div class="cells">
        <label class="label" for="">Email Address</label> <br> <br>
        <input class="input" type="text" name="emailAddress" value="" size="35">
      </div>


      <div class="cells">
        <label class="label" for="">Telephone numer</label> <br> <br>
        <input class="input" type="text" name="tNumb" value="" size="35">
      </div>


      <div class="cells">
        <label class="label" for="">Address 1</label> <br> <br>
        <input class="input" type="text" name="addr1" value="" size="35">
      </div>


      <div class="cells">
        <label class="label" for="">Address 2</label> <br> <br>
        <input class="input" type="text" name="addr2" value="" size="35">
      </div>


      <div class="cells">
        <label class="label" for="">Town</label> <br> <br>
        <input class="input" type="text" name="town" value="" size="35">
      </div>


      <div class="cells">
        <label class="label" for="">County</label> <br> <br>
        <input class="input"type="text" name="county" value="" size="35">
      </div>


      <div class="cells">
        <label class="label" for="">Postcode</label> <br> <br>
        <input class="input" type="text" name="postCode" value="" size="35">
      </div>


      <div class="cells">
        <label class="label" for="">Country</label> <br> <br>
        <!-- <input class="input" type="Country" name="country" value="" size="35"> -->
        <span style="color: red !important; display: inline; float: none;"></span>

            <select class="input" id="country" name="country" class="form-control">
                <option value="Afghanistan">Afghanistan</option>
                <option value="Åland Islands">Åland Islands</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                <option value="Brunei Darussalam">Brunei Darussalam</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote D'ivoire">Cote D'ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Territories">French Southern Territories</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guernsey">Guernsey</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-bissau">Guinea-bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Isle of Man">Isle of Man</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jersey">Jersey</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                <option value="Korea, Republic of">Korea, Republic of</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macao">Macao</option>
                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                <option value="Moldova, Republic of">Moldova, Republic of</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Netherlands Antilles">Netherlands Antilles</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn">Pitcairn</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russian Federation">Russian Federation</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia">Serbia</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-leste">Timor-leste</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viet Nam">Viet Nam</option>
                <option value="Virgin Islands, British">Virgin Islands, British</option>
                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
            </select>
      </div>


      <div class="cellsXL">
        <label class="label" for="">Description</label> <br> <br>
        <textarea class="inputII" name="desc" rows="20" cols="125" maxlength="90%"></textarea>
      </div>

      <div class="fileUpload">
        Your C.V <br>
        Select a file
        <input name="fileToSend" type="file" id="myFile" size="50" style="margin-left: 1.2em">

        <script>
        function myFunction() {
          var x = document.getElementById("myFile").value;
          document.getElementById("demo").innerHTML = x;
        }
        </script>
      </div>

      <?php
      // here we set the success / error flash message
      if (isset($_SESSION["error"])) {
        echo('<p id="errorMessageII" style = "color:red">').htmlentities($_SESSION["errorII"])."</p>\n";
        unset($_SESSION["errorII"]);
      }
      ?>


      <div class="submit">
        <input type="submit" name="submitON" value="SUBMIT"></input>
      </div>

    </form>
    <?php

// ############################################### VIEW ######################################################

    ?>
  </body>
</html>
