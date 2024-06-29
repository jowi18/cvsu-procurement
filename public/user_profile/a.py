class Account:
    def __init__(self):
        self.database = {
            
        }
    def store(self, key, value):
       self.database[key] = value
       
    def display(self):
        for key in self.database:
            print(key, "->", self.database[key])
            
if __name__ == "__main__":
    acc = Account()
    
    notDone = True
    while notDone:
        key = input("Enter Key: ")
        value = input("Enter value: ")
        acc.store(key, value)
        
        choice = input("Do you want to enter new key value pair? (y/n): ")
        if choice == "n":
            notDone = False
    
    print("database values")
    acc.display()
          
        

