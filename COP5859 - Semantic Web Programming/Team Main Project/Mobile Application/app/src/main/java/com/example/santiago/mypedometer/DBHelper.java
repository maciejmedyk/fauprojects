package com.example.santiago.mypedometer;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Hashtable;
import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.sqlite.SQLiteOpenHelper;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Path;
import android.util.Log;

public class DBHelper extends SQLiteOpenHelper {
    private static final String TAG = "HelloService";
    public static final String DATABASE_NAME = "myPedometer.db";
    public static final String TABLE_NAME = "DBstepData";
    public static final String TIMESTAMP_COLUMN_NAME = "TimeStamp";
    public static final String STEPDATA_COLUMN_NAME = "StepData";


    public DBHelper(Context context)
    {
        super(context, DATABASE_NAME, null, 1);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        // TODO Auto-generated method stub
       //db.execSQL(
       //        "create table contacts (id integer primary key, name text,phone text,email text, street text,place text)"
       //);

        db.execSQL("create table " + TABLE_NAME + " (" +
                TIMESTAMP_COLUMN_NAME + " VARCHAR, " +
                STEPDATA_COLUMN_NAME + " VARCHAR)");
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        // TODO Auto-generated method stub
        db.execSQL("DROP TABLE IF EXISTS" + TABLE_NAME);
        onCreate(db);
    }

    public String getDbPath(){
        SQLiteDatabase db = this.getWritableDatabase();
        return db.getPath();
    }



    public void addNewEntry(String stamp, String data){
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put("TimeStamp", stamp);
        contentValues.put("StepData", data);
        db.insert(TABLE_NAME, null, contentValues);
    }

    public String printLastRecord(){
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor resultSet = db.rawQuery("Select * from " + TABLE_NAME, null);
        resultSet.moveToLast();

        String tStamp = resultSet.getString(0);
        String sData = resultSet.getString(1);

        return tStamp + " <> " + sData;
    }



    public Cursor getData(int id)
    {
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery("select * from " + TABLE_NAME + " where id=" + id + "", null);
        return res;
    }

    public Cursor query()
    {
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery( "select * from "+TABLE_NAME, null );
        return res;
    }

    public int numberOfRows()
    {
        SQLiteDatabase db = this.getReadableDatabase();
        int numRows = (int) DatabaseUtils.queryNumEntries(db, TABLE_NAME);
        return numRows;
    }


    public ArrayList<String> getAllCotacts(boolean print)
    {
        ArrayList<String> array_list = new ArrayList<String>();

        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery( "select * from "+TABLE_NAME, null );
        res.moveToFirst();

        while(res.isAfterLast() == false){
            String data_TIMESTAMP_COLUMN_NAME = res.getString(res.getColumnIndex(TIMESTAMP_COLUMN_NAME));
            String data_STEPDATA_COLUMN_NAME = res.getString(res.getColumnIndex(STEPDATA_COLUMN_NAME));
            String valueToAdd = data_TIMESTAMP_COLUMN_NAME + " , " + data_STEPDATA_COLUMN_NAME;
            if(print) {
                Log.i(TAG, valueToAdd);
            }
            array_list.add(valueToAdd);
            res.moveToNext();
        }
        return array_list;
    }



    public void deleteAll(){
        SQLiteDatabase db = this.getWritableDatabase();
        db.execSQL("delete from "+ TABLE_NAME);
    }
   //---------------

    public Integer deleteContact (Integer id)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        return db.delete("contacts",
                "id = ? ",
                new String[] { Integer.toString(id) });
    }

    public boolean insertContact  (String name, String phone, String email, String street,String place)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put("name", name);
        contentValues.put("phone", phone);
        contentValues.put("email", email);
        contentValues.put("street", street);
        contentValues.put("place", place);
        db.insert("contacts", null, contentValues);
        return true;
    }

    public boolean updateContact (Integer id, String name, String phone, String email, String street,String place)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put("name", name);
        contentValues.put("phone", phone);
        contentValues.put("email", email);
        contentValues.put("street", street);
        contentValues.put("place", place);
        db.update("contacts", contentValues, "id = ? ", new String[]{Integer.toString(id)});
        return true;
    }


}