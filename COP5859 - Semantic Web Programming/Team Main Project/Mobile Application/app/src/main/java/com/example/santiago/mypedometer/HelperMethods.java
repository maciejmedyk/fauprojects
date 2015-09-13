package com.example.santiago.mypedometer;

import java.util.Calendar;

/**
 * Created by Santiago on 7/13/2015.
 */
public class HelperMethods {

    public   String TimeStamp(){
        Calendar c = Calendar.getInstance();
        int intSeconds = c.get(Calendar.SECOND);
        int intMinutes = c.get(Calendar.MINUTE);
        int intHours = c.get(Calendar.HOUR_OF_DAY);

        String seconds = "";
        if(intSeconds < 10){
            seconds = "0"+intSeconds;
        }else{
            seconds = ""+intSeconds;
        }

        String minutes = "";
        if(intMinutes < 10){
            minutes = "0"+intMinutes;
        }else{
            minutes = ""+intMinutes;
        }

        String hours = "";
        if(intHours < 10){
            hours = "0"+intHours;
        }else{
            hours = ""+intHours;
        }

        int year = c.get(Calendar.YEAR); // get the current year
        int intMonth = c.get(Calendar.MONTH); // month...
        int intDay = c.get(Calendar.DAY_OF_MONTH); // current day in the month

        String day = "";
        if(intDay < 10){
            day = "0"+intDay;
        }else{
            day = ""+intDay;
        }

        String month = "";
        if(intMonth < 10){
            month = "0"+intMonth;
        }else{
            month = ""+intMonth;
        }

        String date = year + "/" + month + "/" + day;
        String time = hours + ":" + minutes + ":" + seconds;
        String timeStap = date + "," + time;

        return  timeStap;
    }

    //
    private String month(int month){
        switch (month){
            case 1:
                return "JANUARY";
            case 2:
                return "FEBRUARY";
            case 3:
                return "MARCH";
            case 4:
                return "APRIL";
            case 5:
                return "MAY";
            case 6:
                return "JUNE";
            case 7:
                return "JULY";
            case 8:
                return "AUGUST";
            case 9:
                return "SEPTEMBER";
            case 10:
                return "OCTOBER";
            case 11:
                return "NOVEMBER";
            case 12:
                return "DECEMBER";
            default:
                return "error";
        }
    }





}
