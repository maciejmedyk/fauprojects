package FNC_agora;

import java.io.Serializable;
import java.util.ArrayList;

/**
 * Vendor class that contain vendor inventory
 *
 * @author Maciej Medyk and Caio Farias
 */
public class Vendor extends User implements Serializable
{
    /**
     * Vendor constructor creates new vendor
     *
     * @param name vendor full name
     * @param email vendor email
     * @param username vendor username
     * @param password vendor password
     * @param date vendor date of birth
     */
    public Vendor(String name, String email, String username, String password, String date)
    {
        super(name, email, username, password, date);
        inventory = new Inventory();
    }

    /**
     * Function that adds product to vendor array
     *
     * @param name product name
     * @param desc product description
     * @param cat product category
     * @param sp sell price
     * @param ip invoice price
     * @param qty product quantity
     */
    public void addToInventory(String name, String desc, String cat, double sp, double ip, int qty)
    {
        inventory.addProductToInventory(name, desc, cat, sp, ip, qty);
    }

    /**
     * Returns inventory products
     *
     * @return inventory products
     */
    public ArrayList<Product> viewInventory()
    {
        return inventory.viewProducts();
    }

    private Inventory inventory;
}
