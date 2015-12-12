package FNC_agora;

import java.io.Serializable;
import java.util.ArrayList;

/**
 * Cart class that belongs to customer that holds all products
 *
 * @author Maciej Medyk and Caio Farias
 */
public class Cart implements Serializable
{
    /**
     * Cart constructor initiates array that will hold products
     */
    public Cart()
    {
        products = new ArrayList();
    }

    /**
     * Function adds product to the cart
     *
     * @param cp product to add to cart
     */
    public void addProductToCart(Product cp)
    {
        products.add(cp);
    }

    /**
     * Function that returns product array
     *
     * @return product array
     */
    public ArrayList<Product> getCartItems()
    {
        return products;
    }

    /**
     * Function that clones a cart to use it in order
     *
     * @return cart
     */
    public Cart clone()
    {
        Cart n = new Cart();
        for(Product p : this.products)
        {
            n.products.add(p.getClone());
        }
        return n;
    }

    /**
     * Function that clears products array
     */
    public void clear()
    {
        products.clear();
    }

    /**
     * Function that calculates cart amount
     *
     * @return cart amount double
     */
    public double getCartAmount()
    {
        double amount = 0;

        for (Product p : products)
        {
            double price = p.getSellPrice();
            int qty = p.getQuantity();
            amount += price * qty;
        }
        return amount;
    }

    ArrayList<Product> products;
}
