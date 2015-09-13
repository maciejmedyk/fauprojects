package com.example.santiago.mypedometer;

import android.app.AlarmManager;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.os.IBinder;
import android.os.SystemClock;
import android.support.v7.app.NotificationCompat;
import android.util.Log;


public class PedometerService extends Service {

    private static final String TAG = "HelloService";


    Pedometer PedoSensor;

    @Override
    public void onCreate() {
        Log.i(TAG, "Service onCreate");
        PedoSensor = new Pedometer(getApplicationContext());
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

        //Intent causes FC
        Log.i(TAG, "Service onStartCommand - NotificationEnable: " + intent.getBooleanExtra("Notification",false));
        getData(intent.getBooleanExtra("Notification",false));

        return Service.START_REDELIVER_INTENT;
    }

    private void getData(boolean NotificationEnable){

        PedoSensor.addStepsDB();

        if (NotificationEnable) {
            setNotification();
        }
    }


    public void setNotification(){
        NotificationCompat.Builder mBuilder = new NotificationCompat.Builder(getApplicationContext());
        mBuilder.setSmallIcon(R.drawable.icon);
        mBuilder.setContentTitle("Service Running!");
        mBuilder.setContentText(PedoSensor.getSteps());
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
        PedoSensor.destroySensor();
    }



}