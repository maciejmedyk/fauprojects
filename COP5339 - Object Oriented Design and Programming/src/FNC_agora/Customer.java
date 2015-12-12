package FNC_agora;

import java.io.Serializable;
import java.util.ArrayList;

/**
 * Customer class that contains customer cart and orders
 *
 * @author Maciej Medyk and Caio Farias
 */
public class Customer extends User implements Serializable
{
    /**
     * Customer constructor class that adds customer
     *
     * @param name full name of the customer
     * @param email email of the customer
     * @param username username of the customer
     * @param password password of the customer
     * @param date date of birth of the customer
     */
    public Customer(String name, String email, String username, String password, String date)
    {
        super(name, email, username, password, date);
        cart = new Cart();
        orders = new ArrayList<Order>();
    }

    /**
     * Gets the customer cart
     *
     * @return cart
     */
    public Cart getCart()
    {
        return cart;
    }

    /**
     * Function that adds an item to cart
     *
     * @param cp product object
     */
    public void addItemToCart(Product cp)
    {
        cart.addProductToCart(cp);
    }

    /**
     * Function that adds order to array
     *
     * @param o order object
     */
    public void addOrder(Order o)
    {
        orders.add(o);
    }

    /**
     * Gets orders array
     *
     * @return orders array
     */
    public ArrayList<Order> getOrders()
    {
        return orders;
    }

    private Cart cart;
    ArrayList<Order> orders;
}
