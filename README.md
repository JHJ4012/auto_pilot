# Project's outline

On a large-scale university campus, or an institution like a government office, it takes a lot of time and trouble to walk when you have to send something from one building to another. Also, the number of accidents caused by delivery vehicles from outside has soared recently.
To solve this problem, we came to plan the autopilot delivery service called "**Baribari**" which allows people to simply send and receive goods without having to move directly with RC car.


# BariBari
### user (APP)
Sender calls a RC car through the app, put somethings to send in RC cars, and order RC cars to deliver to destination.
When the RC car arrives at its destination, the recipient receive the goods sent to him using QR code.
### manager (WEB)
Managers can check the status of delivery or the status and location of RC car in real time. And also can see statistics of this service or manage stations or RC cars or path. 

# Tech/framework used

- OS: Windows, Ubuntu, AWS
- Back-end: Laravel, Node.JS (Socket.IO), MySQL
- Front-end: Vue.JS, bootstrap, Kakao map API
- App : Android
- Hardware : Raspberry PI 4, Arduino DUE, ROS, RTK-GPS, Lidar


# the part in charge

**Web** 
- Control page
	- check the status of RC car's operation
	- check the status of delivery
	- check the status of waiting delivery
	- check the average of waiting time
	- check most called building's rank
	- track RC cars and check delivery information of RC cars on Map
	- check station's location on Map
- Statistics page (mode : accumulation, average / term : day, week, month)
	- completed delivery
	- completed waiting and canceled waiting
	- average of waiting time
- Error notice
	- when occur error to RC car, show up the error notification 

**App**
 - Call activity
	 - select start point, end point on map, and recipient
	 - order deliver to RC car
 - QR code activity
	 - generate QR code with delivery's information
  
**Hardware**
 - ROS
	 - Use ROS on Raspberry PI 4(Ubuntu 18.04)
	 - connect Arduino DUE (RC car)
 - Make autopilot's algorithm
	 - use RTK-GPS
	 - use azimuth difference between two location
	 - use Lidar to avoid obstacles