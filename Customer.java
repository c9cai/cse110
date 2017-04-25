import java.util.*;

public class Customer {

	//basic customer attributes
	Arraylist<Service> serviceList = new Arraylist<Service>();
	int serviceSize;
	Arraylist<Package> packageList = new Arraylist<Package>();
	int packageSize;
	private String name;
	private String address
	private String accountType;

	//instantiate basic customer variables
	public Customer ( string myName, string myAddress, string type ) {
		name = myName;
		address = myAddress;
		accountType = type;
	}

	//add a service
	public boolean addService ( Service myService ) {
		int index;
		Service currService;

		//iterate through service list
		for ( index = 0; index <= serviceSize; index++ ) {
			currService = serviceList.get( index );

			//false if service already exists
			if ( currService.getLocation() == myService.getLocation() &&
				 currService.getName() == myService.getName() ) 
			{
				return false;
			}
		}

//TODO possible iteration through packages too

		serviceList.add( myService );

		//add service size
		serviceSize++;

		//true if service added successfully
		return true;
	}

	//remove a service
	public boolean deleteService ( Service myService ) {
		int index;
		Service currService;

		for ( index = 0; index <= serviceSize; index++ ) {
			currService = serviceList.get( index );

			//true if service to remove is found
			if ( currService.getLocation() == myService.getLocation() &&
				 currService.getName() == myService.getName() ) 
			{
				serviceList.remove( index );

				return true;
			}
		}

		//subtract service size
		serviceSize--;

		//false if service not found
		return false;
	}

	//cancel services
	public void cancelServices ( Service myService ) {
		serviceList = new Arraylist<Service>();
		packageList = new Arraylist<Package>();
		serviceSize = 0;
		packageSize = 0;
	}
}