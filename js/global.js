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