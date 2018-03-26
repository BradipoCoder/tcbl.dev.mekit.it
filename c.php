<?php
/**
 * Created by Adam Jakab.
 * Date: 22/03/18
 * Time: 9.13
 */
//FORM TEST FOR CALL

/*
firstname
lastname
email                       ( username SSO )
companyName       ( company name )
address                  ( company address )
city                         ( company city )
country                   ( company country )
cap                         (company cap )
province                 ( company province )
 * */

?>
<html>
<body>
<form action="http://thelademo.cleviria.it/tcblCall" method="post"
      enctype="application/x-www-form-urlencoded">
  <div>
    <label for="firstname">First Name</label>
    <input name="firstname" value="Pippo"/>
  </div>

  <div>
    <label for="lastname">Last Name</label>
    <input name="lastname" value="Franco"/>
  </div>

  <div>
    <label for="email">E-mail</label>
    <input name="email" value="pippofranco@gmail.com"/>
  </div>

  <div>
    <label for="companyName">Company name</label>
    <input name="companyName" value="Pippo Inc."/>
  </div>

  <div>
    <label for="address">Street Address</label>
    <input name="address" value="Via Milano, 21"/>
  </div>

  <div>
    <label for="city">City</label>
    <input name="city" value="Torino"/>
  </div>

  <div>
    <label for="cap">ZIP/CAP</label>
    <input name="cap" value="10143"/>
  </div>

  <div>
    <label for="province">Province</label>
    <input name="province" value="TO"/>
  </div>

  <div>
    <label for="country">Country</label>
    <input name="country" value="IT"/>
  </div>

  <button type="submit" value="Send">Send</button>

</form>
</body>
</html>