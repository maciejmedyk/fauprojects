package FNC_agora;

import GUI_agora.Agora;
import GUI_agora.GUI_BrowseItems;
import GUI_agora.GUI_CreateAccount;
import GUI_agora.GUI_Login;
import GUI_agora.GUI_VendorInventory;
import java.io.Serializable;
import java.util.ArrayList;

/**
 * Class that manages users which are customers and vendors
 *
 * @author Maciej Medyk and Caio Farias
 */
public class UserManager implements Serializable
{
    /**
     * User Manager constructor that initiates customer and vendor array
     */
    public UserManager()
    {
        customers = new ArrayList();
        vendors = new ArrayList();
    }

    /**
     * Function that adds vendor
     *
     * @param name vendor name
     * @param email vendor email
     * @param username vendor username
     * @param password vendor password
     * @param date vendor date of birth
     */
    public void addVendor(String name, String email, String username, String password, String date)
    {
        Vendor v = new Vendor(name, email, username, password, date);
        vendors.add(v);
    }

    /**
     * Function that adds customer
     *
     * @param name customer name
     * @param email customer email
     * @param username customer username
     * @param password customer password
     * @param date customer date of birth
     */
    public void addCustomer(String name, String email, String username, String password, String date)
    {
        Customer v = new Customer(name, email, username, password, date);
        customers.add(v);
    }

    /**
     * Function that returns vendor array
     *
     * @return vendors array
     */
    public ArrayList<Vendor> getVendors()
    {
        return vendors;
    }

    /**
     * Function that returns only one vendor
     *
     * @param i index
     * @return vendor user
     */
    public Vendor getVendor(int i)
    {
        return vendors.get(i);
    }

    /**
     * Function that returns only one customer
     *
     * @param i index
     * @return customer user
     */
    public Customer getCustomer(int i)
    {
        return customers.get(i);
    }

    /**
     * Function that returns customer array
     *
     * @return customers array
     */
    public ArrayList<Customer> getCustomers()
    {
        return customers;
    }

    /**
     * Function that verifies credentials and logs in the user
     *
     * @param username username string
     * @param password password string
     * @return boolean that customer was logged in
     */
    public int login(String username, String password)
    {
        for (Vendor user : vendors)
        {
            if (user.getUsername().equals(username) && user.getPassword().equals(password))
            {
                //System.out.println("Vendor logged in");
                vLoggedUser = user;
                loggedName = user.getFullName();
                Agora.desktop.removeAll();
                GUI_VendorInventory vi = new GUI_VendorInventory();
                Agora.desktop.add(vi);
                vi.setVisible(true);
                return 0;
            }
        }
        for (Customer user : customers)
        {
            if (user.getUsername().equals(username) && user.getPassword().equals(password))
            {
                //System.out.println("Customer logged in");
                loggedName = user.getFullName();
                cLoggedUser = user;
                Agora.desktop.removeAll();
                GUI_BrowseItems bi = new GUI_BrowseItems();
                Agora.desktop.add(bi);
                bi.setVisible(true);
                return 0;
            }
        }
        System.out.println("User not found");
        return 1;
    }

    public Customer cLoggedUser;
    public Vendor vLoggedUser;
    public String loggedName;
    private ArrayList<Vendor> vendors;
    private ArrayList<Customer> customers;
}
