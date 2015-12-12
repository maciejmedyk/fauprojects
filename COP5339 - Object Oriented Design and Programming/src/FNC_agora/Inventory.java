package FNC_agora;

import GUI_agora.Agora;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.Random;

/**
 * Inventory class holds all the vendor products 
 *
 * @author Maciej Medyk and Caio Farias
 */
public class Inventory implements Serializable
{
    /**
     * Inventory constructor initiates 
     */
    public Inventory()
    {
        products = new ArrayList();
    }

    /**
     * Function that adds Product to Inventory
     *
     * @param name name of the product
     * @param desc description of the product
     * @param cat category of the product
     * @param sp sell price of the product
     * @param ip invoice price of the product
     * @param qty quantity of the product
     */
    public void addProductToInventory(String name, String desc, String cat, double sp, double ip, int qty)
    {
        int rand = generateRandom();
        Product p = new Product(rand,name, desc, cat, sp, ip, qty);
        products.add(p);
    }

    /**
     * Function that returns the array of products
     *
     * @return products array
     */
    public ArrayList<Product> viewProducts()
    {
        return products;
    }

    /**
     * Generates the unique random number for product id
     *
     * @return random number
     */
    private int generateRandom()
    {
        int min = 1000000;
        int max = 9999999;
        Random rand = new Random();
        int randomNum = 0;
        int count = 0;
        while(count == 0)
        {
            randomNum = rand.nextInt((max - min) + 1) + min;
            ArrayList<Vendor> vl = Agora.um.getVendors();
            for(Vendor v : vl)
            {
                for(Product p : v.viewInventory())
                {
                    if(p.getProductID()== randomNum)
                    {
                        count++;
                    }
                }
            }
            if (count == 0) return randomNum;
        }
        return randomNum;
    }

    private ArrayList<Product> products;
}
