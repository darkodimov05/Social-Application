<!DOCTYPE html>
<html>
    <head>
        <title>Social Login and SignUP</title>
		<link rel="stylesheet" type="text/css" href="styles/style.css" media="all">
    </head>

    <body>
        <div id="main-container">
            <div id="header">
                <div id="logo">
                    Social
                </div>

                <div class="login_form">
                    <form method="post" id="login_form" action="login.php">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Email</td><td>Password</td>
                                </tr>
                                <tr>
                                    <td>
                                      <input type="Email" name="email" placeholder="Enter your email" required="required"/>
                                    </td>
                                    <td>
                                      <input type="Password" name="pass" placeholder="Enter your password" required="required"/>
                                    </td>
                                    <td>
                                      <button id="btn1" name="login">Login</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <input type="Checkbox"/><span style="text-decoration: none;color: #7FFF00;">Keep me Logged in</span>
                                    </td>

                                    <td>
                                       <a style="text-decoration: none; color: #7FFF00;" href="#">Forrgoten Password?</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
