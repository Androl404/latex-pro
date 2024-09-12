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
    <title>User Documentation of LaTeX-pro</title>
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
            <h1>User Documentation of <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span></h1>
            <p>This page contains all the informations about how the tool should be used and about all his functionnalities.</p>
            <p>This tool was naturally conceived to work on a modern browser on a modern (from my point of view) computer. We recommand using Web browsers like Mozilla Firefox, Chromium, Google Chrome or Microsoft Edge. We DO NOT support any mobile browsers, Apple's Safari and deprecated versions of any Internet browser.</p>
            <h2>Your account</h2>
            <h3>How does your account work</h3>
            <p>By creating yourself an account, you will enter some of your personal data and a password, which we recommand you to be a random generated password provided by your browser of a special software, or a password you will only use for our service. All of your personal information can be seen in your personal <a href="../dashboard.php">dashboard</a> and can also be modificated from there. The user name, full name and email inputs are already filled in with the information located in our database. These are the actual possessions stored in our systems. In the case your want to modify your informations, you can change them trought your personal <a href="../dashboard.php">dashboard</a> and submit the form. In the case you want to change your password, please also fill in the password and repeat passord inputs. If you leave them blank, the password will not be changed. At the bottom of your <a href="../dashboard.php">dashboard</a> will also appear the last date and time connection. If you think someone else not authorized has logged in your account, please password the password as quick as possible and contact the administrators with the <a href="../contact.php"></a> form.</p>
            <h3>Connecting to your account</h3>
            <p>You can connect to your account with this <a href="../login.php">page</a> (inaccessible if you are already logged-in). You can log out with by clicking <a href="../php-scripts/logout.php">here</a> or by using the option accessible from the page's header, also from where your personal <a href="../dashboard.php">dashboard</a> can be accessed.</p>
            <p>In the case you are inactive for a certain time, you will be logged out automatically by PHP after 1440 seconds, which is corresponding to 24 minutes. If you are in the edit page, all the actions will fail after that delay of inactivity and we recommand to always make sure your files are saved before leaving your computer for any amount of time.</p>
            <h3>Deleting your account</h3>
            <p>In the case you want to delete your account and all the projects stored with your account. Please use the contact form dedicated to all kind of requests, which can be found right <a href="../contact.php">here</a>.</p>
            <h2>Your <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> projects</h2>
            <h3>The header</h3>
            <p>After you successfully log in, you will be able to accesslots of different pages from our software, including the edit page. All these page have something in common: the header and the footer.</p>
            <p>The header contains the following elements, from left to right:</p>
            <ul>
                <li>First, there is our <span class="bold">logo and name of the platform</span> in the left part of the header. This is in fact a link which will redirect you to the <a href="../index.php">index page</a> if you are connected, else to the <a href="../login.php">log-in page</a>.</li>
                <li>Then on the right side of the header, you might see an button leading you to the <span class="bold">Administrator Control Panel</span>. This button will only show up if you are an administrator, as well as the access to the page.</li>
                <li>The next button should appear to anybody, since clicking on it will redirect you to the <a href="../index.php">index page</a>, where you can find all of your <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> projects.</li>
                <li>Finally, the last element will contain the full name you specified in our systems. By overing this button, multiple options will appear. First will appear your e-mail adress, then a link to your <a href="../dashboard.php">personal dashboard</a>, and finally, a button to <a href="../php-scripts/logout.php">log-out</a> of our systems.</li>
            </ul>
            <p>The header should remain identical throught all the pages you will be exploring, except the edit page.</p>
            <h3>The footer</h3>
            <p>The footer can be found in any of our web pages, by scrolling to the very bottom. The footer contains three parts (from left to right): the first contains our logo and name, the second part (located to the right) contains useful links, aiming to our different policies, documentation pages, or <a href="../contact.php">contact form</a>. Finally, the last part can be seen at the bottom fo the footer, can contains our copyright mark as well as the name and e-mail adress of the maintainer.</p>
            <p>The footer should remain identical throught all the pages you will be exploring, except the edit page.</p>
            <h3>About the administration of <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> projects</h3>
            <p>Once you are logged in with your account, you can start creating and editing <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> projects from the index page.</p>
            <h4>The index page</h4>
            <p>In this page, you can create <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> projects from the form at the top of the page. The projects will then appear in the table following the creation form.</p>
            <p>While creating a new project, there are some restrain of the name of the project. You must use and only use digits from 0 to 9, any letter from A to Z (not case sensitive), dashes (-), underscores (_), and dots (.). Any non respect of this rule will cause the creation of the project to fail. In both cases, a popup will notify you on the success, or the failure of the operation.</p>
            <p>It is also important to note that our tool is not able to rename a project yet, this functionnality will be soon implemented.</p>
            <p>The table containing your projects displays several informations, like the name of the project, several dates, and several actions you can apply to one of your projects.</p>
            <p>Three actions are available to you:</p>
            <ul>
                <li><span class="bold">Recycle the project:</span> this actions will move your project to the recycle-bin, and will no more appear in the index page.</li>
                <li><span class="bold">Archive the project:</span> this actions will move your project to the archived projects, and will no more appear in the index page.</li>
                <li><span class="bold">See the archive of your project:</span> this will take you to a special page where you can see all the archived version of a project.</li>
            </ul>
            <p>By using some of these actions, the projects will appear in different category available from the left panel in the projects pages.</p>
            <h4>The archived projects page</h4>
            <p>This page contains all the projects you archived in a table, displaying the same informations as in the index page.</p>
            <p>Once again, you can perform different actions on a project:</p>
            <ul>
                <li><span class="bold">Recycle the project:</span> this actions will move your project to the recycle-bin, and will no more appear in the index page.</li>
                <li><span class="bold">De-archive the project:</span> this actions will move your project back to the index page.</li>
            </ul>
            <p>By using some of these actions, the projects will appear in different category available from the left panel in the projects pages.</p>
            <h4>The recycle bin page</h4>
            <p>This page contains all the projects you recycled in a table, displaying the same informations as in the index page.</p>
            <p>Once again, you can perform different actions on a project:</p>
            <ul>
                <li><span class="bold">Completely delete a project:</span> when completely deleting a project, the directory of your project is completely deleted from our servers as well as are the archives of the project you are deleting. <span class="bold">So think twice before deleting a project!</span></li>
                <li><span class="bold">Restore the project:</span> this actions will move your project back to the index page.</li>
            </ul>
            <p>By using some of these actions, the projects will appear in different category available from the left panel in the projects pages.</p>
            <h4>The archived project's versions page</h4>
            <p>On this page accessible from the index page, you can visualize all the back-ups you made for each project.</p>
            <p>You will see in a table all the <span class="code">zip</span> files you created, as well as some actions you can perform on each of your back-up: </p>
            <ul>
                <li><span class="bold">Restore the archive:</span> this will restore the <span class="code">zip</span> file into your projects. It is important to know that only the files present in yout archive will be overwritten.</li>
                <li><span class="bold">Delete the archive:</span> this will definitively delete the archive. <span class="bold">Think twice before doing that!</span></li>
            </ul>
            <p class="bold">We recommand you to frequently made back-ups of your projects, even if you do not download it on the fly. It important for any projects to have back-up, for any eventually.</p>
            <p>This tool has been initially conceived for your main <span class="code">.tex</span> file to be named <span class="code">main.tex</span>. While we provide an option in the menu to compile any <span class="code">.tex</span> file which can be found in your projects, some functionnalities might not work properly (the 'download PDF file' button for example). Additionally, the editor will prompt you an error on the opening of your project if your project does not contain the <span class="code">main.tex</span> file at the root of your project.</p>
            <p class="bold">It is important to note that a deleted project cannot be recovered, even by the administrators of this software. A recycled or archived project can still be edited and compiled.</p>
            <h2>The edit page</h2>
            <p>The edit page is composed of multiple elements which will be described below.</p>
            <h3>The header</h3>
            <p>The header of the edit page is composed of three elements:</p>
            <ul>
                <li>the menu button, which allows you to toggle the appearance of the menu;</li>
                <li>the home button, which allows you to go back to the index page with the list of your projects. Make sure your files are saved before doing so;</li>
                <li>the project name defined at the project's creation;</li>
                <li>the file status, which is composed of the actual file you are currently editing, and its save status; the file can be saved, not saved, saving or not saved with an error.</li>
            </ul>
            <h4>The auto-saving feature</h4>
            <p>Our editor supports auto-save of the file you are editing. Refer to the file status in the header to know what is happening.</p>
            <p>Once you made a modification of a saved file in the editor, the file status will change to 'not saved'. The file will then be saved after three seconds, if there is not another modification made to the file in the editor. So the editor will wait three seconds after the last modification and then save the file. You can also manually save the file using the button in the action menu or the shortcut <span class="key-short">Ctrl + S</span>. Manually saving a file will abort the planned saving request (if there is one).</p>
            <p>While the saving is in progress, the file status will indicate 'saving...'. If the file is saved, the file status will indicate 'saved'. If an error occured, the file status will indicate 'error on save'. In the case there is an error, please verify your Internet connection, and you cannot get back your Internet connection, please save the file you are editing on your device locally, waiting for it to access the Wordl Wide Web again.</p>
            <h4>The Internet breakdown detector</h4>
            <p>Our editor is endowed with an Internet breakdown detector, which detects a lack of Internet connection.</p>
            <p>This works by verifying if one of our file is available on our servers. If this file is available, then everything is working great! If not, a popup will appear in the top middle of your screen, stating what you are disconnected and that files won't be saved. By the way, we recommand you to locally save the file your are editing if that ever happens to you.</p>
            <p>In the popup will appear a counter which will check if your device is reconnected to the Internet every ten seconds. There is also a button which allows you to try to reconnect youself with a single click.</p>
            <p>A while ago, our software was build in a way that we were checking every five seconds your Internet connection with a request to our servers. In an more environmental friendly approach to our software implementation, we deciced to check for your Internet connection every time a request in your editor fails. A failing request does not means that your Internet connection is down, but it is a more ecological (and clever) way to verify if you connection is still up, or not.</p>
            <h3>The menu</h3>
            <p>The appearance of the menu can be toogled with the 'Menu' button in the header, at the top left of the editor. The menu is composed on multiple sections: Download, Compilation options, Editor options, Notifications options and Help.</p>
            <p>Your preferences are saved every three seconds after you made a modification to one of the settings in the menu.</p>
            <h4>Download</h4>
            <p>In the download section, you have multiple options:</p>
            <ul>
                <li><span class="bold">Download the PDF file:</span> This will look for a file called <span class="code">main.pdf</span>. If the file exists, a new tab will open with the PDF file. If the file does not exists, this will look, for a file with the same name you are editing but with the <span class="code">pdf</span> extension. If none of these file exists, a toast notification will notify you about the failure of the downloading.</li>
                <li><span class="bold">Download an archive of the project:</span> This will create then propose you to download a <span class="code">.zip</span> file of your project (it includes all the files). The created archive will also be saved and accessible in the future from the index page. We recommand you to frequently create an archive of your project, so you will have all the necessary back-ups if something was to happen.</li>
                <li><span class="bold">View all the archives of the project:</span> This will open a new tab in your browser with all the saved archives of your projects. You can then download the archives, delete them from our server or even restore one.</li>
            </ul>
            <h4>Compilation options</h4>
            <p>In this section, you can choose the compiler which will be used to compile your document. By default, pdfLaTeX will take care of the job, but you can also choose to compile with the classic LaTeX compiler which will produce a <span class="code">dvi</span> file. XeLaTeX can also be choosen to compile your file, and we are currently working to add support for LuaLaTeX. Except the LaTeX compiler, all the others compiler produces a <span class="code">pdf</span> file.</p>
            <p>You can also enable the <span class="code">--shell-escape</span> argument to be added to the command line launching the compiler. This will allow you to run external commands for your <span class="code">.tex</span> file or from the different packages you are including in your document. Learn more about this argument <a href="https://tex.stackexchange.com/questions/88740/what-does-shell-escape-do">here</a>.</p>
            <p>InkScape is installed on our server (to include <span class="code">svg</span> files in your document for example) but the package <span class="code">minted</span> can also be used in order to colorize code.</p>
            <p>The third and last option available allows you to choose what <span class="code">.tex</span> file you want to compile from your project. As said earlier, this piece of software has been conceived to compile mainly the <span class="code">main.tex</span> file, but if you need to compile another quickly in order to get a draft or something, this option is still provided. You can choose a file in any of the directories or subdirectories of your project but all the ouput files will be written in the root of your project due to some limitations and compatibilities with the <span class="code">--shell-escape</span> argument.</p>
            <h4>Editor options</h4>
            <p>We provide multiple options in order to allow you to customize your writing experience. First of all, you can choose your font size in the editor for your comfort. The minimal size is 5pt and the maximal size is 99pt.</p>
            <p>We also allow you to change the editor theme. The default theme is the dark theme, but you can choose the light theme, or the light and dark hich contrast themes, for accessibilities reasons. There are also a lot more themes available and we are letting you find the one that fits you most.</p>
            <p>You then have four checkboxes, providing different functionnalities:</p>
            <ul>
                <li><span class="bold">Enable word wrap:</span> this is activated by default, and will wrap the words on line which are too long to be fully displayed. By deactivating this option, you might need to do some horizontal scrolling, which can be achieved by pressing the <span class="key-short">Shift</span> key and then using your mouse wheel.</li>
                <li><span class="bold">Show the minimap:</span> this will show a map of your document on the right of the editor, this option is not activated by default.</li>
                <li><span class="bold">Enable VIM mode:</span> this will activate the popular key-bindings from the VIM text editor. A little panel will also appear at the bottom of the editor indicate you the current mode you are in. Command you are typing will also be shown there. For more information on the VIM keybindings, check <a href="https://quickref.me/vim">this</a>.</li>
                <li><span class="bold">Enable relative line numbers:</span> this options is not activated by default and will show the relative line numbers based on the line your cursor is currently on. This can be really useful for VIM users.</li>
            </ul>
            <h4>Notifications options</h4>
            <p>In the editor, notifications are displayed as toast notifications in the bottom right of your browser's window. These notifications can get stacked on top of each other and automatically dissapear after a certain amount of time.</p>
            <p>There are four type of notifications: success, info, warning and error, each one with his own color and icon. The success and info notifications will generaly dissapear after five seconds and the warning and error notification will dissapear after ten seconds on the screen. You can also manually close them by clicking on the cross button.</p>
            <p>With the two checkboxes in this section, you toggle the appearance of the success and info notifications, and the warning and error notifications. By default, the appearance of the success and info notifications is disabled.</p>
            <p>A while ago, all the toast notifications were appearing on the screen; these were useful in order to debug the tool and improve it. But with some feedback from our users, we decided to disable the info and success notifications, because they were stating too become annoying to the users.</p>
            <h4>Help</h4>
            <p>The 'Help' section contains three links aiming to:</p>
            <ul>
                <li>the documentation you are currently reading;</li>
                <li>the <a href="shortcuts.php">keyboard shortcuts</a> part of the documentation;</li>
                <li>a <a href="../contact.php">contact page</a> in order to contact us.</li>
            </ul>
            <p>These links should help you in case you need help, or do not understand a functionnality of this tool.</p>
            <h3>The actions menu</h3>
            <p>The actions menu is located right above the project's tree and below the header. This menu is composed of different icons, and each icon is associated to one particular action. You can hover the icon to get a little description of what the actions does. Each click on one of the icon execute an action. Let's go throught all the icons and explain in details what each icon does in order of appearance in the menu:</p>
            <ul>
                <li><span class="bold">Refresh the current file:</span> You should not normally need to use this button. It simply re-load the content of the file you are currently edinting from the server in the editor. Before it loads the file, the file will not be saved, so make you will not lose any content. The file is automatically loaded at the loading of the edit page.</li>
                <li><span class="bold">Save the current file:</span> By cliking on this icon, the file you are currently editing in the editor will be saved in our server. In the case the operation fail, we recommand you to keep a temporary back-up of the file with your modifications in local on your computer. You should normally not need to use this action since the auto-save feature has been implemented into the tool.</li>
                <li><span class="bold">Update project's tree:</span> This will update the project's tree available at the left of the editor below the action's menu. While we try to update it the most frequently possible, you might need to update it manually.</li>
                <li><span class="bold">Create a new file:</span> This will open a dialog pop-up in order to ask you for the name of a new file. It is important to note that the name of the new file shall not longer than 225 characters and all the characters must be numbers from '0' to '9', UTF-8 letters from 'a' to 'z' and from 'A' to 'Z'. Dots, dashes and underscores are also accepted. If these requirements are not met, an error will be thrown and the file will not be created. You can also create file in subdirectories, by using the following syntax: <span class="code">subdir/subsubdir/new_file.extension</span>. Ending the file name with a slash will indeed create a new directory with the name you specified.</li>
                <li><span class="bold">Create a new directory:</span> This will open a dialog pop-up in order to ask you for the name of a new directory. As for a new file, the name of the new directory shall not contain more than 225 characters and must include the valid characters stated right above. If these requirements are not met, an error will be thrown and the directory will not be created. It is recommended to end your input string with a slash, but this is not an obligation and the directory should still be created with, or without a slash at the end of the input string. If you want to create a directory in a subdirectory, you can use the following syntax: <span class="code">subdir/new_directory/</span>.</li>
                <li><span class="bold">Move/rename a file or a directory:</span> This will open two dialog pop-up. In the first dialog pop-up, you can enter the name of a file, of multiple files using the <a href="https://www.malikbrowne.com/blog/a-beginners-guide-glob-patterns/">glob syntax</a>, a directory (with everything he contains recursively), multiple directories, or a mixture of directories and files. Think about it as you're selecting all the files you want to perform an operation on. Then, you are greeted with a second pop-up window, in which you can type a location in which to put all the files and directories you selected, or if you selected only one file, you can simply rename the file or put it in a different directory. A simpler way to think about the move action is the <span class="code">mv</span> command herited from <span class="code">UNIX</span> systems. The syntax can be compared to the following: <span class="code">mv <i>first_input second_input</i></span>.</li>
                <li><span class="bold">Delete a file or a directory:</span> This will open a pop-up dialog windows in which you can specify all the files or directoires you want to permanently remove from your project. <span class="bold">Keep mind that the files you delete cannot be recovered, even by the administrators!</span> You can use the <a href="https://www.malikbrowne.com/blog/a-beginners-guide-glob-patterns/">glob syntax</a> to delete multiple files or directories ('*', '?' and braces). This input can be compared to the first input of the move/rename action.</li>
                <li><span class="bold">Toggle the upload zone:</span> This button allows you to toogle the appearance of the upload zone in the middle top of the editor. By default, the upload zone is not displayed since it might not be used all day long.</li>
                <li><span class="bold">Clean the project's file:</span> This actions will look throught all the files at the root of your project and delete all the files with the following extensions: <span class='code'>log</span>, <span class='code'>aux</span>, <span class='code'>dvi</span>, <span class='code'>lof</span>, <span class='code'>lot</span>, <span class='code'>loa</span>, <span class='code'>lol</span>, <span class='code'>bit</span>, <span class='code'>idx</span>, <span class='code'>glo</span>, <span class='code'>bbl</span>, <span class='code'>bcf</span>, <span class='code'>ilg</span>, <span class='code'>toc</span>, <span class='code'>ind</span>, <span class='code'>out</span>, <span class='code'>blg</span>, <span class='code'>fdb_latexmk</span>, <span class='code'>fls</span>, <span class='code'>run</span>, <span class='code'>xml</span>, <span class='code'>synctex.gz</span>, <span class="code">xdv</span> et <span class="code">pyg</span>. If a directory called <span class="code">_minted-main</span> is found, it will also be deleted.</li>
            </ul>
            <p>After each of these actions is completed, with an error or not, a toast notification will appear in the top right of the screen, indicating the success of the failure of the actions you wanted to complete. <span class="bold">These notifications might not appear if they are disabled in the menu!</span></p>
            <h3>The project's tree</h3>
            <p>The project's tree is, of course, composed of the files in your project. In reality, each project is corresponding to a folder on our server. The project's tree is in fact a representation of all the files located in your project's folder.</p>
            <p>First will appear the folder sorted in alphabetical order, and then will appear the files also sorted in alphabetical order.</p>
            <p>It is important to note that the project's tree is not automatically updated. While we try to update it the most we can, we also advise you to manually refresh it from time to time in the action's menu.</p>
            <p>We are also working on a featuring preventing for the open folders to be closed when the tree is refresh, in order to give more comfort to the user.</p>
            <h3>The file upload zone</h3>
            <p>The file upload zone is hidden by default and his appearance can be toggled with a button in the action's menu or with a keyboard shorcut (more about shortcuts <a href="shortcuts.php">here</a>). It is located at the middle top of the editor.</p>
            <p>In order to upload files, you can drag and drop them in the upload zone, or you can click on 'Browse'. This will open the file explorer on your device and you will be able to select multiple files to upload.</p>
            <p><span class="bold">Keep in mind that you can only upload 40 files at a time with a total size of 50 MB at a time!</span></p>
            <p>The upload status of each file will then appear in the upload zone, and the project's tree should be refreshed. The upload status of each file will disappear if you refresh the edit page.</p>
            <p>It is also important to note that this feature is behaving quite weird, be careful while using it! Maintainers will take a look at this, but it is not a priority.</p>
            <h3>The <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> editor</h3>
            <p>One of the most important part of a tool like this one is the <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> text editor. Our editor is based on the Monaco Editor developped by Microsoft and which is powering Visual Studio Code. This means that most of the features and shortcuts available in Visual Studio Code are available in our editor. For example, the shorcut <span class="key-short">F1</span> opens the command palette in the editor, allowing you to choose an action to complete from a list.</p>
            <p>Hence, most of the Visual Studio Code text editor functionalities are available in this editor (multi-cursors for example), as well as the majority of the shortcuts.</p>
            <h3>The compile bar</h3>
            <p>The compile bar is located right above the PDF reader, in the top right of the editor below the header. This bar is composed of three elements:</p>
            <ul>
                <li><span class="bold">The compile button:</span> this button allows you to compile your project, it will use the compiler specified in the menu and will compile the file also specified in the menu. Our tool is using the <span class="code">latexmk</span> Perl compilation script, so you don't have to compile multiple time your document if needed. While your document is compiling, the circular arrow from the compile button will be turning around, so you know if a compiling task is executing. It is also important to note that <span class="code">latexmk</span> will ignore any configuration file in your project.</li>
                <li><span class="bold">The view-log button:</span> this button will toggle the appearance of a panel on the PDF reader which will allow you to see the errors, warnings and infos produced by the compiler. The raw-log will be displayed at the bottom of this panel, but is also accessible from his file in the project's tree.</li>
                <li>Three numbers indicating the number of errors, warnings and infos from the compilation log. These numbers will appear only after the first compilation and will be updated after each compilation.</li>
            </ul>
            <h3>The errors viewer</h3>
            <p>By clicking on the view-log button in the compile bar, next to the compile button, you can toggle the appearance of the view-log panel.</p>
            <p>If the first open the editor, you will see a message asking you to compile your projects in order to get the log and display errors, warnings and infos. Once you compiled your project, you might see errors, warnings and infos displayed. If there is one or more errors, the compilation of your project failed, and you need to correct your files in order to not get any errors. If you only got warnings or/and info, you can safely ignore them (who reads them, really?).</p>
            <p>The messages in this panel are sorted before they are displayed. First are diplayed errors, then warnings, then infos, and finally the full raw log.</p>
            <h3>The PDF viewer</h3>
            <p>On the right on the editor is the PDF viewer. It allows you to see the result of your compilation, only of a PDF file is produced. If you are compiling your project with the LaTeX compiler and getting a <span class="code">dvi</span> file as output, you might need an external program to visualize it.</p>
            <p>Depending on the browser you are using, different PDF reader might be used, because we are using the browser PDF viewer. We still recommand you to use the <a href="https://github.com/mozilla/pdf.js">PDF.js</a> viewer, which is maintained by the Mozilla Foundation and is used by default on the Mozilla Firefow browser. It can also be installed and used as default PDF viewer on other browser by installing his own extension.</p>
            <h2>Archiving projects</h2>
            <p>Our tool allows you to create archive of your projects which can be visible from a button in the index page.</p>
            <p>You can create an archive of the project from the menu in the edit page. You can choose to download it or not, but it will always be saved and accessible in the future. You can always download any archive you created later and these will never be deleted automatically.</p>
            <p>You can also choose to restore an archive. When restoring an archive, all the files present in the archive will be overwritten or created in your project. Files not present in the archive but which are existing in the project will not affected and will have to be deleted manually by the user.</p>
            <p>We recommand you to frequently create an archive of your projects, even if you don't instantly download it, so a back-up of your project will be kept.</p>
        </div>
    </div>

    <?php require("footer.php"); ?>
    <script src="../js/toc.js"></script>
</body>

</html>
