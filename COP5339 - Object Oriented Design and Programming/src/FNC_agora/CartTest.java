/*
package FNC_agora;

import java.util.ArrayList;
import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;
import static org.junit.Assert.*;

*/
/**
 * Tests Cart Functions
 *
 * @author Maciej Medyk and Caio Farias
 *//*

public class CartTest {

    public CartTest() {
    }

    @BeforeClass
    public static void setUpClass() {
    }

    @AfterClass
    public static void tearDownClass() {
    }

    @Before
    public void setUp() {
    }

    @After
    public void tearDown() {
    }

    */
/**
     * Test of addProductToCart method, of class Cart.
     *//*

    @Test
    public void testAddProductToCart() {
        System.out.println("addProductToCart");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product cp = new Product(123 ,name, desc, cat, sp, ip, qty);
        Cart instance = new Cart();
        instance.addProductToCart(cp);
        assertTrue(instance.getCartItems().contains(cp));
    }

    */
/**
     * Test of getCartItems method, of class Cart.
     *//*

    @Test
    public void testGetCartItems() {
        System.out.println("getCartItems");
        Cart instance = new Cart();
        ArrayList<Product> expResult = new ArrayList<Product>();
        ArrayList<Product> result = instance.getCartItems();
        assertEquals(expResult, result);
    }

    */
/**
     * Test of clone method, of class Cart.
     *//*

    @Test
    public void testClone() {
        System.out.println("clone");
        System.out.println("addProductToCart");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Cart instance = new Cart();
        instance.addProductToCart(new Product(123, name, desc, cat, sp, ip, qty));
        Cart expResult = new Cart();
        expResult.addProductToCart(new Product(123, name, desc, cat, sp, ip, qty));
        Cart result = instance.clone();
        assertTrue(result.getCartItems().get(0).getProductName() == expResult.getCartItems().get(0).getProductName());
    }

    */
/**
     * Test of clear method, of class Cart.
     *//*

    @Test
    public void testClear() {
        System.out.println("clear");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Cart instance = new Cart();
        instance.addProductToCart(new Product(123, name, desc, cat, sp, ip, qty));
        Cart expResult = new Cart();
        instance.clear();
        assertTrue(instance.getCartItems().size() == expResult.getCartItems().size());
    }

    */
/**
     * Test of getCartAmount method, of class Cart.
     *//*

    @Test
    public void testGetCartAmount() {
        System.out.println("getCartAmount");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Cart instance = new Cart();
        instance.addProductToCart(new Product(123, name, desc, cat, sp, ip, qty));
        double expResult = sp * qty;
        double result = instance.getCartAmount();
        assertTrue(expResult == result);
    }
}
*/
