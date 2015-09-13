package com.example.santiago.mypedometer;

import android.app.Activity;
import android.app.ActivityManager;
import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.PorterDuff;
import android.net.Uri;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.TextView;
import android.widget.Toast;

import java.io.File;


public class MainActivity extends Activity implements View.OnClickListener {

    private static final String TAG = "HelloService";

    long alarmTime = 900;  //* 1000
    DBHelper dataBase;
    //Intent intent;
    String msgText_Text;
    //Intent alarmIntent;

    static private Button start_ServiceButton;
    static private Button stop_ServiceButton;
    static private Button print_ServiceButton;

    static private CheckBox Notification_checkBox;

    static private Button eraseDB_ServiceButton;

    static private Button bluetooth_ServiceButton;



    static private TextView msgText_TextView;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main2);

        dataBase = new DBHelper(getApplicationContext());

        dbPath = dataBase.getDbPath();

        GUIelementsInit();


    }


    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.start_service:
                GUIelementsStart();
                start();
                break;
            case R.id.stop_Service:
                GUIelementsStop();
                cancel();
                break;
            case R.id.print_result:
                printOnClick(v);
                break;
            case R.id.ErraseDB_button:
                dataBase.deleteAll();
                break;
            case R.id.bluetooth_button:
                //Bluetooth();
                ExportCSV exportCSV = new ExportCSV(this);
                File filePath = exportCSV.createCSV();
                sendBluetooth(filePath);
                break;

        }
    }

    private void Bluetooth(){
        Intent m = new Intent(this, BluetoothActivity.class);
        m.putExtra("Path", dbPath);
        startActivity(m);
    }

    private void sendBluetooth(File path){

        // bring up Android chooser
        Intent intent = new Intent();
        intent.setAction(Intent.ACTION_SEND);
        intent.setType("text/plain");
        intent.putExtra(Intent.EXTRA_STREAM, Uri.fromFile(path));
        //...
        startActivity(intent);
    }

    public void printOnClick(View v){
        Log.i(TAG, "Print all Records----------");
        msgText_Text = textViewPrintINFO();

        if(dataBase.numberOfRows() > 0) {
            for (String txt : dataBase.getAllCotacts(false)) {
                Log.i(TAG, "record: " + txt);
                msgText_Text = msgText_Text + "\n" + txt;
            }
        }else{
            msgText_Text = msgText_Text + "\n" + "DATABASE EMPTY";
        }
        msgText_TextView.setText(msgText_Text);
    }

    public void start() {
        AlarmManager manager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);

        Intent alarmIntent = new Intent(MainActivity.this, MyReceiver.class);
        alarmIntent.putExtra("Notification", Notification_checkBox.isChecked());
        PendingIntent pendingIntent = PendingIntent.getBroadcast(MainActivity.this, 0, alarmIntent, PendingIntent.FLAG_UPDATE_CURRENT);

        manager.setInexactRepeating(AlarmManager.RTC_WAKEUP, System.currentTimeMillis(), (1000 * alarmTime), pendingIntent);
    }


    public void cancel() {
        AlarmManager manager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);
        Intent alarmIntent = new Intent(MainActivity.this, MyReceiver.class);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(MainActivity.this, 0, alarmIntent, 0);
        manager.cancel(pendingIntent);

        Intent intent = new Intent(MainActivity.this, PedometerService.class);
        stopService(intent);

        Toast.makeText(this, "Alarm Canceled", Toast.LENGTH_SHORT).show();
    }

    String dbPath = "";



    //---GUI-----------------------------
    private void GUIelementsInit(){
        start_ServiceButton = (Button) findViewById(R.id.start_service);
        start_ServiceButton.setOnClickListener(this);

        stop_ServiceButton = (Button) findViewById(R.id.stop_Service);
        stop_ServiceButton.setOnClickListener(this);

        print_ServiceButton = (Button) findViewById(R.id.print_result);
        print_ServiceButton.setOnClickListener(this);

        bluetooth_ServiceButton = (Button) findViewById(R.id.bluetooth_button);
        bluetooth_ServiceButton.setOnClickListener(this);

        Notification_checkBox = (CheckBox) findViewById(R.id.Notification_checkBox);
        Notification_checkBox.setChecked(true);

        eraseDB_ServiceButton = (Button) findViewById(R.id.ErraseDB_button);
        eraseDB_ServiceButton.setOnClickListener(this);

        stop_ServiceButton.setEnabled(false);
        stop_ServiceButton.getBackground().setColorFilter(Color.DKGRAY, PorterDuff.Mode.MULTIPLY);

        print_ServiceButton.getBackground().setColorFilter(Color.RED, PorterDuff.Mode.MULTIPLY);
        print_ServiceButton.setEnabled(false);

        msgText_TextView = (TextView) findViewById(R.id.msg_text);
        msgText_TextView.setSingleLine(false);
        msgText_TextView.setMaxLines(32);
        msgText_TextView.setVerticalScrollBarEnabled(true);
        msgText_TextView.setHorizontalScrollBarEnabled(true);
        msgText_TextView.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);
        msgText_TextView.setMovementMethod(new ScrollingMovementMethod());

        msgText_TextView.setText(textViewPrintINFO());
    }
    private void GUIelementsStart(){
        start_ServiceButton.setEnabled(false);
        start_ServiceButton.getBackground().setColorFilter(Color.DKGRAY, PorterDuff.Mode.MULTIPLY);

        stop_ServiceButton.setEnabled(true);
        stop_ServiceButton.getBackground().setColorFilter(Color.WHITE, PorterDuff.Mode.MULTIPLY);

        print_ServiceButton.getBackground().setColorFilter(Color.GREEN, PorterDuff.Mode.MULTIPLY);
        print_ServiceButton.setEnabled(true);

        eraseDB_ServiceButton.setEnabled(false);

        Notification_checkBox.setEnabled(false);

    }
    private void GUIelementsStop(){
        start_ServiceButton.setEnabled(true);
        start_ServiceButton.getBackground().setColorFilter(Color.WHITE, PorterDuff.Mode.MULTIPLY);

        stop_ServiceButton.setEnabled(false);
        stop_ServiceButton.getBackground().setColorFilter(Color.DKGRAY, PorterDuff.Mode.MULTIPLY);

        print_ServiceButton.getBackground().setColorFilter(Color.RED, PorterDuff.Mode.MULTIPLY);
        print_ServiceButton.setEnabled(false);

        eraseDB_ServiceButton.setEnabled(true);

        Notification_checkBox.setEnabled(true);
    }
    private String textViewPrintINFO(){
        String alarmInterval = "Time Lapse between alarms: " + alarmTime + " secs" + " or " + alarmTime/60 + " mins";
        String path = "The Path to the DB file: " + dbPath;
        path = "";
        String notificationEnable = "Showing Notifications? " + Notification_checkBox.isChecked();
        String numberOfRowsOfDb = "How Many rows in the DataBase:  " + dataBase.numberOfRows()+"";

        String text = alarmInterval + "\n" + notificationEnable + "\n" + numberOfRowsOfDb + "\n" + path ;
        return  text;
    }


}