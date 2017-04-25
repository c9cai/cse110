public class Service {

  private String name;
  private double price;
  private String location;
  private int speed;

  public Service (String name, double price, String location, int speed) {
    this.name = name;
    this.price = price;
    this.location = location;
    this.speed = speed;
  }

  public void setName(String name){
    this.name = name
  }
  
  public void setPrice(double price){
    this.price = price;
  }
  
  public void setLocation(String location) {
    this.location = location;

  public void setSpeed(int speed){
    this.speed = speed;
  }

  public String getName() {
    return name;
  }

  public double getPrice() {
    return price;
  }

  public String getLocation(){
    return location;
  }
  
  public int getSpeed(){
    return speed;
  }
}
