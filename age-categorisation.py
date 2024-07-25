# Define the price as a float and determine the price category
price = float(150.75)  # Example price

if price < 50:
    print("Price Category: Budget")
elif 50 <= price < 100:
    print("Price Category: Standard")
elif 100 <= price < 200:
    print("Price Category: Premium")
else:
    print("Price Category: Luxury")