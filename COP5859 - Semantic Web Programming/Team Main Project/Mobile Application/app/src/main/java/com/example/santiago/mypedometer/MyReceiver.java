package com.example.santiago.mypedometer;

import android.app.NotificationManager;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.hardware.Sensor;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.support.v7.app.NotificationCompat;
import android.util.Log;
import android.widget.Toast;

public class MyReceiver extends BroadcastReceiver {
    public MyReceiver() {
    }
    private static final String TAG = "HelloService";

    @Override
    public void onReceive(Context context, Intent intent) {
        boolean NotificationEnable = intent.getBooleanExtra("Notification", false);

        Log.i(TAG, "onReceive - NotificationEnable: " + intent.getBooleanExtra("Notification", false));

        Intent newIntent = new Intent(context, PedometerService.class);
        newIntent.putExtra("Notification", NotificationEnable);

       context.startService(newIntent);

    }


}
