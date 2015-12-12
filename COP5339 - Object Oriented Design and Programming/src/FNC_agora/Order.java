package FNC_agora;

import java.io.Serializable;
import java.util.Date;

/**
 * Order class keeps track of cart and customer that made an order
 *
 * @author Maciej Medyk and Caio Farias
 */
public class Order implements Serializable
{
    /**
     * Order constructor that adds cart and customer to order
     *
     * @param ct cart clone
     * @param c customer clone
     */
    public Order(Cart ct, Customer c)
    {
        mCart = ct;
        mCustomer = c;
        mTimestamp = new Date();
    }

    /**
     * Function that returns cart content 
     *
     * @return cart object
     */
    public Cart getCart()
    {
        return mCart;
    }

    /**
     * Function that returns timestamp
     *
     * @return timestamp
     */
    public Date getDate()
    {
        return mTimestamp;
    }

    /**
     * Function that returns customer content
     *
     * @return customer object
     */
    public Customer getCustomer()
    {
        return mCustomer;
    }

    private Cart mCart;
    private Customer mCustomer;
    private Date mTimestamp;
}
