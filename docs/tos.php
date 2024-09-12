<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Services (ToS) - LaTeX-pro</title>
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link rel="stylesheet" href="../css/latex.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/content.css">
    <link rel="icon" href="../img/favicon/icon_128.png" />
    <link rel="stylesheet" href="../modules/boxicons-2.1.4/css/boxicons.min.css">
    <script src="../modules/jquery-3.7.1/jquery.min.js"></script>
</head>

<body>

    <?php require("header.php"); ?>

    <div id="content-doc">
        <div>
            <nav id="toc">
                <h1 class="invisible">Table of contents</h1>
            </nav>
            <p><span class="bold">Last Updated:</span> Friday 19<sup>th</sup> of July 2024, 09:55 AM</p>

            <h1>Terms of Service</h1>

            <p>Welcome to <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> ("Service", "we", "us", "our"). Please read these Terms of Service ("Terms", "Terms of Service") carefully before using the <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> website (the "Service") operated by Andrei D. Zeucianu ("us", "we", or "our").</p>

            <h2>1. Acceptance of Terms</h2>

            <p>By accessing or using our Service, you agree to be bound by these Terms. If you do not agree with any part of the Terms, you may not access the Service.</p>

            <h2>2. Changes to Terms</h2>

            <p>We reserve the right to modify or replace these Terms at any time. If a revision is material, we will provide at least 30 days' notice before any new terms take effect. What constitutes a material change will be determined at our sole discretion.</p>

            <h2>3. Use of Service</h2>

            <p>You agree to use the Service only for lawful purposes and in accordance with these Terms. You agree not to use the Service:</p>

            <ul>
                <li>In any way that violates any applicable national or international law or regulation.</li>
                <li>To exploit, harm, or attempt to exploit or harm minors in any way by exposing them to inappropriate content or otherwise.</li>
                <li>To transmit, or procure the sending of, any advertising or promotional material, including any "junk mail," "chain letter," "spam," or any other similar solicitation.</li>
                <li>To impersonate or attempt to impersonate Andrei D. Zeucianu, a <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> employee, another user, or any other person or entity.</li>
                <li>To engage in any other conduct that restricts or inhibits anyone's use or enjoyment of the Service, or which, as determined by us, may harm <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> or users of the Service or expose them to liability.</li>
            </ul>

            <h2>4. Account Registration</h2>

            <p>To access the main features of the Service, you must register for an account. You must provide accurate and complete information and keep your account information updated. You are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer. You agree to accept responsibility for all activities that occur under your account or password.</p>

            <h2>5. Termination</h2>

            <p>We may terminate or suspend your account and bar access to the Service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever and without limitation, including but not limited to a breach of the Terms.</p>

            <h2>6. Intellectual Property</h2>

            <p>The Service and its original content, features, and functionality are and will remain the exclusive property of <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> and its licensors. The Service is protected by copyright, trademark, and other laws of both the United States and foreign countries. Our trademarks and trade dress may not be used in connection with any product or service without the prior written consent of <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>.</p>

            <h2>7. Limitation of Liability</h2>

            <p>In no event shall <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from (i) your use or inability to use the Service; (ii) any unauthorized access to or use of our servers and/or any personal information stored therein; (iii) any interruption or cessation of transmission to or from the Service; (iv) any bugs, viruses, trojan horses, or the like that may be transmitted to or through our Service by any third party; (v) any errors or omissions in any content or for any loss or damage incurred as a result of the use of any content posted, emailed, transmitted, or otherwise made available through the Service; and/or (vi) the defamatory, offensive, or illegal conduct of any third party. In no event shall <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> be liable for any claims, proceedings, liabilities, obligations, damages, losses, or costs of any amount you paid to <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>.</p>

            <h2>8. Governing Law</h2>

            <p>These Terms shall be governed and construed in accordance with the laws of France and Europe, without regard to its conflict of law provisions.</p>

            <h2>9. Contact Us</h2>

            <p>If you have any questions about these Terms, please contact us with the form we put at your disposition right <a href="../contact.php">here</a>.</p>
        </div>
    </div>

    <?php require("footer.php"); ?>
    <script src="../js/toc.js"></script>

</body>

</html>
