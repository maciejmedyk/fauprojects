package com.example.santiago.mypedometer;

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

/**
 * Created by Santiago on 7/19/2015.
 */
public class ExportCSV {

    private File filePath;

    Context context;
    public ExportCSV(Context cont) {
        filePath = new File(Environment.getExternalStorageDirectory(), fileNameFormat()+".csv");
        context = cont;
    }


    private String fileNameFormat(){
        //DetailedStep_year_month_day_time
        String fileName = "DetailedSteps";
        int year = Calendar.getInstance().get(Calendar.YEAR);

        int monthInt = Calendar.getInstance().get(Calendar.MONTH);
        String month;

        int dayInt = Calendar.getInstance().get(Calendar.DAY_OF_MONTH);
        String day;

        if(dayInt < 10){
            day = "0"+dayInt;
        } else {
            day = ""+dayInt;
        }

        if(monthInt < 10){
            month = "0"+monthInt;
        } else {
            month = ""+monthInt;
        }

        int timeH = Calendar.getInstance().get(Calendar.HOUR_OF_DAY);
        int timeM = Calendar.getInstance().get(Calendar.MINUTE);

        return  fileName+"_"+year+"_"+month+"_"+day+"_"+timeH+""+timeM;
    }

    public File createCSV(){
        convertCSV();

        return filePath;
    }
    /**
     * Creates the CSV file containing data about past days and the steps taken on them
     * <p/>
     * Requires external storage to be writeable
     */
    private void convertCSV() {
        if (Environment.getExternalStorageState().equals(Environment.MEDIA_MOUNTED)) {

            if (filePath.exists()) {

                new AlertDialog.Builder(context).setMessage(R.string.file_already_exists)
                        .setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                dialog.dismiss();
                                writeToFile(filePath);
                            }
                        }).setNegativeButton(android.R.string.cancel, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                }).create().show();


            } else {
                writeToFile(filePath);
            }
        } else {
            new AlertDialog.Builder(context)
                    .setMessage(R.string.error_external_storage_not_available)
                    .setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            dialog.dismiss();
                        }
                    }).create().show();
        }
    }

    private void writeToFile(final File f) {
        BufferedWriter out;
        try {
            f.createNewFile();
            out = new BufferedWriter(new FileWriter(f));
        } catch (IOException e) {

            new AlertDialog.Builder(context)
                    .setMessage(context.getString(R.string.error_file, e.getMessage()))
                    .setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            dialog.dismiss();
                        }
                    }).create().show();

            e.printStackTrace();
            return;
        }

        DBHelper db = new DBHelper(context);

        Cursor c = db.query();

        try {
            if (c != null && c.moveToFirst()) {
                while (!c.isAfterLast()) {

                    out.append(c.getString(0)).append(",").append(String.valueOf(Math.max(0, c.getInt(1)))).append("\n");

                    c.moveToNext();
                }
            }

            out.flush();
            out.close();
        } catch (IOException e) {

            new AlertDialog.Builder(context)
                    .setMessage(context.getString(R.string.error_file, e.getMessage()))
                    .setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            dialog.dismiss();
                        }
                    }).create().show();

            e.printStackTrace();
            return;
        } finally {
            if (c != null) c.close();
            //db.close();
        }

        new AlertDialog.Builder(context)
                .setMessage(context.getString(R.string.data_saved, f.getAbsolutePath()))
                .setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                }).create().show();

    }


}
