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


        print("\n2. Clicking right arrow button once...")
        try:
            right_arrow = WebDriverWait(driver, 10).until(
                EC.element_to_be_clickable((By.CSS_SELECTOR, 
                    "button.carousel-control-next, "
                    ".arrow-right, "
                    "[aria-label='Next'], "
                    "[data-direction='next']")))
            
            right_arrow.click()
            print("✓ Right arrow clicked once")
            time.sleep(1)
        except TimeoutException:
            print("- Right arrow not found (proceeding anyway)")

        print("\n3. Clicking 'Try Fulltext Search' button...")
        try:
            fulltext_btn = WebDriverWait(driver, 15).until(
                EC.element_to_be_clickable((By.XPATH, 
                    "//a[contains(., 'Try Fulltext Search') or "
                    "contains(., 'Fulltext Search')]")))
            
            driver.execute_script("arguments[0].scrollIntoView({block: 'center', behavior: 'smooth'});", fulltext_btn)
            time.sleep(0.5)
            fulltext_btn.click()
            print("✓ Fulltext search button clicked")
        except TimeoutException:
            print("! Failed to find fulltext search button")
            raise

        print("\n4. Searching for 'Harry Potter'...")
        try:
            search_inputs = WebDriverWait(driver, 15).until(
                EC.presence_of_all_elements_located((By.CSS_SELECTOR, 
                    "input[type='search'], "
                    "input[name='q'], "
                    "#searchBox")))
            
            if len(search_inputs) >= 2:
                second_search = search_inputs[1]
                second_search.clear()
                second_search.send_keys("The only way to do great work is to love what you do")
                second_search.send_keys(Keys.RETURN)
                print("✓ 'The only way to do great work is to love what you do' search executed in second search box")
                
                
                WebDriverWait(driver, 15).until(
                    EC.presence_of_element_located((By.XPATH, 
                        "//*[contains(text(), 'The only way to do great work is to love what you do')]")))
                print("✓ Search results containing 'The only way to do great work is to love what you do' found")
            else:
                raise TimeoutException("Second search box not found")
        except TimeoutException:
            print("! Search failed or no results found")
            raise

    finally:
        time.sleep(5)  
        driver.quit()

if __name__ == "__main__":
    test_openlibrary()