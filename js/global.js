//Global Variables
var notifiedTasks = [];

//Global JS Functions
    function startTime()
    {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var dd = today.getDate();

        var mm = today.getMonth()+1; 
        var yyyy = today.getFullYear();
        if(dd<10) 
        {
            dd='0'+dd;
        } 

        if(mm<10) 
        {
            mm='0'+mm;
        } 

        var dateString = dd + "/" + mm + "/" + yyyy;

        m = checkTime(m);
        s = checkTime(s);

        var weekday = new Array(7);
        weekday[0] =  "Sunday";
        weekday[1] = "Monday";
        weekday[2] = "Tuesday";
        weekday[3] = "Wednesday";
        weekday[4] = "Thursday";
        weekday[5] = "Friday";
        weekday[6] = "Saturday";

        var dayOfWeek = weekday[today.getDay()];

        document.getElementById('dateTime').innerHTML = dayOfWeek + " " + dateString + " " + h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
        var t2 = setTimeout(CheckNotifications, 500);

        DarkModeCheck();
    }

    function CheckNotifications()
    {
        var nTCookie = getCookie(removeSpaces("notifiedtasks"));
        if(nTCookie!="" && nTCookie!=null)
        {
            notifiedTasks = JSON.parse(nTCookie);
        }

         //gets table
        var oTable = document.getElementById('sqlTable');

        //gets rows of table
        var rowLength = oTable.rows.length;

        //loops through rows    
        for (i = 0; i < rowLength; i++)
        {
            if(!notifiedTasks.includes(i))
            {
                //gets cells of current row  
                var oCells = oTable.rows.item(i).cells;
                var today = new Date();
                var repeat = oCells.item(1).innerHTML;
                var repeatRate = oCells.item(2).innerHTML;
                var taskDate = oCells.item(3).innerHTML;
                var DayOfWeek = oCells.item(4).innerHTML;
                var Hour = oCells.item(5).innerHTML;
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();

                if(repeat=="1")
                {
                    if(repeatRate=="Daily")
                    {
                        m = checkTime(m);
                        s = checkTime(s);
                        
                        var timeSplitArr = Hour.split(":");
                        if(timeSplitArr[0]==h)
                        {
                            if(m>timeSplitArr[1] && m<=59)
                            {
                                notifiedTasks.push(i);
                                setCookie('notifiedtasks', JSON.stringify(notifiedTasks));
                                Notify(oCells.item[0].innerHTML);
                            }
                        }
                    }
                    else if(repeatRate=="Weekly")
                    {
                        var weekday = new Array(7);
                        weekday[0] =  "Sunday";
                        weekday[1] = "Monday";
                        weekday[2] = "Tuesday";
                        weekday[3] = "Wednesday";
                        weekday[4] = "Thursday";
                        weekday[5] = "Friday";
                        weekday[6] = "Saturday";

                        var n = weekday[today.getDay()];
                        if(DayOfWeek == n)
                        {
                            m = checkTime(m);
                            s = checkTime(s);
                            
                            var timeSplitArr = Hour.split(":");
                            if(timeSplitArr[0]==h)
                            {
                                if(m>timeSplitArr[1] && m<=59)
                                {
                                    notifiedTasks.push(i); 
                                    setCookie('notifiedtasks', JSON.stringify(notifiedTasks));
                                    Notify(oCells.item(0).innerHTML);
                                }
                            }
                        }
                    }
                }
                else if(repeat=="0")
                {
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();

                    today = yyyy+"-"+mm+"-"+dd;
                    if(taskDate == today)
                    {
                        m = checkTime(m);
                        s = checkTime(s);
                        
                        var timeSplitArr = Hour.split(":");
                        if(timeSplitArr[0]==h)
                        {
                            if(m>timeSplitArr[1] && m<=59)
                            {
                                notifiedTasks.push(i);     
                                setCookie('notifiedtasks', JSON.stringify(notifiedTasks));
                                Notify(oCells.item(0).innerHTML);
                            }
                        }
                    }
                }
            }
        }
    }

    function Notify(string)
    {
        Notification.requestPermission().then(function(result){
            alert(string);
        });
    }

    function checkTime(i) 
    {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    function TabPage(id)
    {
        var tab = document.getElementById(id);
        var tabPage = document.getElementById("tP"+id);

        var tabs = document.getElementsByClassName("tab");
        var tabPages = document.getElementsByClassName("tabPage");

        for(var i=0; i<tabs.length; i++)
        {
            tabs[i].classList.remove("selected");
        }

        for(var j=0; j<tabPages.length; j++)
        {
            tabPages[j].classList.add("hidden");
        }

        tab.classList.add("selected");
        tabPage.classList.remove("hidden");
    }

    function setCookie(cname,cvalue) //Sets a cookie to expire on the next day at midnight
    {
    	var now = new Date();
    	var expire = new Date();
    
    	expire.setFullYear(now.getFullYear());
    	expire.setMonth(now.getMonth());
    	expire.setDate(now.getDate()+1);
    	expire.setHours(0);
    	expire.setMinutes(0);
        expire.setSeconds(0);
   
    	var expires = "expires="+expire.toString();
    	document.cookie = cname + "=" + cvalue + "; " + expires +"; path=/";
    }


    function getCookie(input) {
        var cookies = document.cookie.split(';');
        if(cookies!=undefined && cookies!=null && cookies.length>0)
        {
            for (var i = 0; i < cookies.length; i++) {
                var name = removeSpaces(cookies[i].split('=')[0].toLowerCase());
                var value = removeSpaces(cookies[i].split('=')[1].toLowerCase());
                if (name == input) {
                  return value;
                } else if (value == input) {
                  return name;
                }
              }
              return "";
        }
    };

    function removeSpaces(string)
    {
        return string.replace(" ","");
    }

    function DarkModeCheck()
    {
        let root = document.documentElement;
        if(getCookie("darkmode")=="true")
        {
            if(!document.getElementById("darkModeSwitch").classList.contains("active"))
            {
                root.style.setProperty("--panel-bgcolor", "#000");
                root.style.setProperty("--bgcolor", "#565656");
                root.style.setProperty("--content-color", "#fff");
                document.getElementById("darkModeSwitch").classList.add("active");
                document.getElementById("darkModeIcon").classList.add("fa-moon");
                document.getElementById("darkModeIcon").classList.remove("fa-sun");
            }
        }
        else
        {
            if(document.getElementById("darkModeSwitch").classList.contains("active"))
            {
                root.style.setProperty("--panel-bgcolor", "#6ab446");
                root.style.setProperty("--bgcolor", "#f2f6e9");
                root.style.setProperty("--content-color", "#000");
                document.getElementById("darkModeSwitch").classList.remove("active");
                document.getElementById("darkModeIcon").classList.add("fa-sun");
                document.getElementById("darkModeIcon").classList.remove("fa-moon");
            }
        }
    }

    function DarkModeToggle()
    {
        if(getCookie("darkmode")=="true")
        {
            setCookie("darkmode","false");
        }
        else
        {
            setCookie("darkmode","true");
        }

        DarkModeCheck();
    }