package FNC_agora;

import java.io.Serializable;

/**
 * User class holds user name, login credentials, etc
 *
 * @author Maciej Medyk and Caio Farias
 */
public class User implements Serializable
{
    /**
     * Constructor creates user
     *
     * @param name full name
     * @param email email of user
     * @param username login username
     * @param password login password
     * @param date date of birth
     */
    public User(String name, String email, String username, String password, String date)
    {
        mName = name;
        mEmail = email;
        mUsername = username;
        mPassword = password;
        mDate = date;
    }

    /**
     * Returns login username of user
     *
     * @return username string 
     */
    public String getUsername()
    {
        return mUsername;
    }

    /**
     * Returns password of user
     *
     * @return password string
     */
    public String getPassword()
    {
        return mPassword;
    }

    /**
     * Returns email of user
     *
     * @return email string
     */
    public String getEmail()
    {
        return mEmail;
    }

    /**
     * Returns date of birth of user
     *
     * @return date of birth string
     */
    public String getDateOfBirth()
    {
        return mDate;
    }

    /**
     * Returns full name of user
     *
     * @return full name string
     */
    public String getFullName()
    {
        return mName;
    }

    /**
     * Sets the password of the user
     *
     * @param pass password string
     */
    public void setPassword(String pass)
    {
        mPassword = pass;
    }

    private String mName;
    private String mEmail;
    private String mUsername;
    private String mPassword;
    private String mDate;
}
