package com.example.santiago.mypedometer;
//https://tsicilian.wordpress.com/2012/11/06/bluetooth-data-transfer-with-android/
//http://examples.javacodegeeks.com/android/core/bluetooth/bluetoothadapter/android-bluetooth-example/
//http://www.tutorialspoint.com/android/android_bluetooth.htm

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Environment;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;

import java.io.BufferedWriter;
import java.io.File;
import java.io.IOException;

import android.content.Context;
import android.content.DialogInterface.OnClickListener;
import android.database.Cursor;
import android.widget.Toast;

import java.io.FileWriter;
import java.util.Calendar;

public class BluetoothActivity extends Activity implements View.OnClickListener{



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_bluetooth);


        ExportCSV exportCSV = new ExportCSV(this);
        File filePath = exportCSV.createCSV();
        sendBluetooth(filePath);


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



    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_bluetooth, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.convertToCSV_button:
                //exportCSV.convertCSV();

                break;
            case R.id.sendToBluetooth_button:

                //sendBluetooth();

                break;
        }
    }





}
