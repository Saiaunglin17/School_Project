from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
import time

def test_openlibrary():
    options = webdriver.ChromeOptions()
    options.add_argument("--start-maximized")
    driver = webdriver.Chrome(options=options)
    
    try:
        print("1. Loading OpenLibrary...")
        driver.get("https://openlibrary.org/")
        
        WebDriverWait(driver, 15).until(
            EC.title_contains("Open Library"))
        print("✓ Homepage loaded successfully")

        print("\n4. Searching for 'Romeo'...")
        try:
            search_box = WebDriverWait(driver, 15).until(
                EC.element_to_be_clickable((By.CSS_SELECTOR, 
                    "input[name='q'], "
                    "input[type='search'], "
                    "#searchBox")))
            
            search_box.clear()
            search_box.send_keys("Romeo")
            search_box.send_keys(Keys.RETURN)
            print("✓ Search for 'Romeo' executed")
            
            WebDriverWait(driver, 15).until(
                EC.presence_of_element_located((By.XPATH, 
                    "//*[contains(text(), 'Romeo')]")))
            print("✓ Search results containing 'Romeo' found")
        except TimeoutException:
            print("! Search failed or no results found")
            raise

    finally:
        time.sleep(5)
        driver.quit()

if __name__ == "__main__":
    test_openlibrary()