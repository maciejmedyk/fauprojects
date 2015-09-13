package com.example.santiago.mypedometer;

import android.annotation.TargetApi;
import android.content.Context;
import android.hardware.Sensor;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.hardware.SensorManager;
import android.os.Build;
/**
 * Created by Santiago on 7/19/2015.
 */
public class Pedometer implements SensorEventListener {
    private static final String TAG = "HelloService";
    Context context;
    private String countString;
    HelperMethods method;
    DBHelper dataBase;

    public Pedometer(Context cont) {
        context = cont;
        reRegisterSensor();
        dataBase = new DBHelper(cont);
        method = new HelperMethods();
    }

    @Override
    public void onSensorChanged(SensorEvent event) {

        countString = String.valueOf(event.values[0]);
    //TODO: research if this is necesary
        reRegisterSensor();
    }

    @Override
    public void onAccuracyChanged(Sensor sensor, int accuracy) {

    }

    public String getSteps(){
        return countString;
    }

    public void addStepsDB(){
        String stamp = method.TimeStamp();

        dataBase.addNewEntry(stamp, getSteps());
        //Log.i(TAG, "HelloService: " + dataBase.printLastRecord());
    }

    public void destroySensor(){
        try {
            SensorManager sm = (SensorManager) context.getSystemService(context.SENSOR_SERVICE);
            sm.unregisterListener(this);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @TargetApi(Build.VERSION_CODES.KITKAT)
    private void reRegisterSensor() {
        SensorManager sm = (SensorManager)  context.getSystemService(context.SENSOR_SERVICE);
        try {
            sm.unregisterListener(this);
        } catch (Exception e) {
            //if (BuildConfig.DEBUG) Logger.log(e);
            e.printStackTrace();
        }

        // enable batching with delay of max 5 min
        sm.registerListener(this, sm.getDefaultSensor(Sensor.TYPE_STEP_COUNTER),
                SensorManager.SENSOR_DELAY_NORMAL, 5 * 60000000);
    }

}
