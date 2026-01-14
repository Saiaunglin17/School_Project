from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
import time

def open_library():
    options = webdriver.ChromeOptions()
    options.add_argument("--start-maximized")
    driver = webdriver.Chrome(options=options)
    
    try:
        print("Launching Open Library website...")
        driver.get("https://openlibrary.org/")
        
        WebDriverWait(driver, 15).until(
            EC.title_contains("Open Library"))
        print("✓ Website loaded successfully")

        print("\nLocating 'Read Free Library Books Online' button...")
        try:
            # Try multiple possible selectors for the button
            free_books_btn = WebDriverWait(driver, 15).until(
                EC.element_to_be_clickable((By.XPATH, 
                    "//a[contains(., 'Read Free Library Books Online') or "
                    "contains(., 'Read Free Books Online') or "
                    "contains(., 'Free Library Books')]")))
              
            driver.execute_script("arguments[0].scrollIntoView({block: 'center', behavior: 'smooth'});", free_books_btn)
            time.sleep(0.5)
            free_books_btn.click()
            print("✓ Button clicked successfully")
            
            WebDriverWait(driver, 15).until(
                lambda d: "books" in d.title.lower() or "read" in d.title.lower())
            print("✓ Free books page loaded")
            
        except TimeoutException:
            print("! Could not find or click the button")
            raise

    finally:
        time.sleep(5)
        driver.quit()

if __name__ == "__main__":
    open_library()