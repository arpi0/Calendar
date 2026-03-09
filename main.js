let loggedin = false;
function logalert()
{

if ( loggedin== false)
    {
        var resp = window.prompt("Login to your account", "Username");
        var pass = window.prompt("Password", "Password");
        document.getElementById("demo").innerText = resp;
        loggedin= true;
    }
else 
    {
        alert("already signed in");
    }
}

function newdate() 
{
if(loggedin==true)
    {
        var name = window.prompt("Name of your event");
        var date = window.prompt("Date of your event");

        document.getElementById(date).innerText = name;
    }
else 
    {
        alert("Please sign in to make an event");
    }
}

function saveUserTimes() {
    $.post("savesettings.php",
    {
        name: $("#userName").val(),
        password: $("#password").val(),
    },
    function(data,status){
        document.getElementById("saveWarningText").innerHTML = data;
        $( "#saveWarningText" ).fadeIn(100);
        setTimeout(function(){ $( "#saveWarningText" ).fadeOut(100); }, 3000);
    });
}