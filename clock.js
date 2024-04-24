function Updateclock(){
    const today = new Date();
    const hours = today.getHours();
    const minutes = today.getMinutes();
    const seconds = today.getSeconds();
    const date = today.getDate();
    const month = today.getMonth();
    const year = today.getFullYear();
    const daynum = today.getDay();

    var days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
    const day = days[daynum - 1];

    const hour = hours < 10 ? "0" + hours : hours;
    const minute = minutes < 10 ? "0" + minutes : minutes;
    const second = seconds < 10 ? "0" + seconds : seconds;

    const hourtime = hour > 12 ? hour - 12 : hour;

    const ampm = hour < 12 ? "AM" : "PM";
    const formattedTime = hourtime+":"+minute+":"+second+" "+ampm;
    const formattedDate = date+"/"+(month+1)+"/"+year;

    document.getElementById("clock").textContent = formattedTime;
    document.getElementById("date").textContent = formattedDate;
    //document.getElementById("day").textContent = day;
}
    //console.log(day);
Updateclock();
setInterval(Updateclock, 1000);