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
 * Tests Inventory Functions
 *
 * @author Maciej Medyk and Caio Farias
 *//*

public class InventoryTest {

    public InventoryTest() {
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
     * Test of addProductToInventory method, of class Inventory.
     *//*

    @Test
    public void testAddProductToInventory() {
        System.out.println("addProductToInventory");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Inventory instance = new Inventory();
        instance.addProductToInventory(name, desc, cat, sp, ip, qty);
        Product p = new Product(123 ,name, desc, cat, sp, ip, qty);
        assertTrue(instance.viewProducts().get(instance.viewProducts().size() - 1).getProductName().equals(p.getProductName()));
    }

    */
/**
     * Test of viewProducts method, of class Inventory.
     *//*

    @Test
    public void testViewProducts() {
        System.out.println("viewProducts");
        Inventory instance = new Inventory();
        ArrayList<Product> expResult = new ArrayList<Product>();
        ArrayList<Product> result = instance.viewProducts();
        assertEquals(expResult, result);
    }
}
*/
