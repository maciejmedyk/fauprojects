package com.example.santiago.mypedometer;

import android.app.AlarmManager;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.content.pm.ResolveInfo;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.IBinder;
import android.os.SystemClock;
import android.support.v7.app.NotificationCompat;
import android.util.Log;

import java.util.Calendar;
import java.util.List;
import java.util.Random;
import java.util.Timer;
import java.util.TimerTask;

public class HelloService extends Service {

    private static final String TAG = "HelloService";
    Timer myTimer;
    boolean NotificationEnable;
    //int fireTime = 30000; //30000 = 30 Seconds Interval.
    int fireTime = 300000; //30000 = 30 Seconds Interval.


    int timerRunCycleCount = 0;
    //private boolean isRunning  = false;
    //SQLiteDatabase mydatabase;
    DBHelper dataBase;

    @Override
    public void onCreate() {
        Log.i(TAG, "Service onCreate");

        dataBase = new DBHelper(getApplicationContext());

    }

    @Override
    public void onTaskRemoved(Intent rootIntent){
        Intent restartServiceIntent = new Intent(getApplicationContext(), this.getClass());
        restartServiceIntent.setPackage(getPackageName());

        PendingIntent restartServicePendingIntent = PendingIntent.getService(getApplicationContext(), 1, restartServiceIntent, PendingIntent.FLAG_ONE_SHOT);
        AlarmManager alarmService = (AlarmManager) getApplicationContext().getSystemService(Context.ALARM_SERVICE);
        alarmService.set(
                AlarmManager.ELAPSED_REALTIME,
                SystemClock.elapsedRealtime() + 1000,
                restartServicePendingIntent);

        super.onTaskRemoved(rootIntent);
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {

        //Causing FC
        NotificationEnable = intent.getBooleanExtra("Notification",false);

        Log.i(TAG, "Service onStartCommand - NotificationEnable: " + NotificationEnable);


        myTimer = new Timer();
        myTimer.schedule(new TimerTask() {
            @Override
            public void run() {
                timerRunCycleCount = timerRunCycleCount + 1;
                String stamp = TimeStamp();
                //--remove
                Random r = new Random();
                int i1 = r.nextInt(80 - 65) + 65;
                //----
                dataBase.addNewEntry(stamp, "Cycle: " + timerRunCycleCount +" Rand: "+ i1);

                Log.i(TAG, "HelloService: " + dataBase.printLastRecord());
                //----
                if(NotificationEnable) {
                    setNotification();
                }
                //----
            }
        }, 0, fireTime); //30000 = 30 Seconds Interval.


        return Service.START_STICKY;
    }

    private  String TimeStamp(){
        Calendar c = Calendar.getInstance();
        int seconds = c.get(Calendar.SECOND);
        int minutes = c.get(Calendar.MINUTE);
        int hours = c.get(Calendar.HOUR_OF_DAY);

        int year = c.get(Calendar.YEAR); // get the current year
        int month = c.get(Calendar.MONTH); // month...
        int day = c.get(Calendar.DAY_OF_MONTH); // current day in the month

        String date = year + "/" + month(month) + "/" + day;
        String time = hours + ":" + minutes + ":" + seconds;
        String timeStap = date + " - " + time;

        return  timeStap;
    }
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

    public void setNotification(){
        NotificationCompat.Builder mBuilder = new NotificationCompat.Builder(getApplicationContext());
        mBuilder.setSmallIcon(R.drawable.icon);
        mBuilder.setContentTitle("Service Running!");
        mBuilder.setContentText(dataBase.printLastRecord());

        NotificationManager mNotificationManager = (NotificationManager) getSystemService(getApplicationContext().NOTIFICATION_SERVICE);

        mNotificationManager.notify(0, mBuilder.build());
    }
    @Override
    public IBinder onBind(Intent arg0) {
        Log.i(TAG, "Service onBind");
        return null;
    }

    @Override
    public void onDestroy() {

        Log.i(TAG, "Service onDestroy");
        myTimer.cancel();
    }
}