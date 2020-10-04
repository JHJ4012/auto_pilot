**UCC**
 - UCC Link : [Go to see project's UCC](https://youtu.be/76wWuedsmEA "Go to see project's UCC")

# Project's outline

On a large-scale university campus, or an institution like a government office, it takes a lot of time and trouble to walk when you have to send something from one building to another. Also, the number of accidents caused by delivery vehicles from outside has soared recently.
To solve this problem, we came to plan the autopilot delivery service called "**Baribari**" which allows people to simply send and receive goods without having to move directly with RC car.


# BariBari
### user (APP)
Sender calls a RC car through the app, put somethings to send in RC cars, and order to RC cars to deliver to destination.
When the RC car arrives at its destination, the recipient receive the goods sent to him using QR code.
### manager (WEB)
Managers can check the status of delivery or the status and location of RC car in real time. And also can see statistics of this service or manage stations or RC cars or path. 

# Tech/framework used

- OS: Windows, Ubuntu, AWS EC2
- Back-end: PHP(Laravel), Node.JS (Socket.IO), MySQL
- Front-end: Vue.JS, bootstrap, Kakao map API
- App : Android
- Hardware : Raspberry PI 4, Arduino DUE, RTK-GPS, Lidar, ROS, Python


# the part in charge

**Web** 
- Control page
	- present the status of RC car's operation in real time
	- present the status of delivery in real time
	- present the status of waiting delivery in real time
	- present the average of waiting time in real time
	- present most called building's rank
	- track RC cars and present delivery information of RC cars on Map in real time
	- present station's location on Map in real time
- Statistics page (mode : accumulation, average / term : day, week, month)
	- completed delivery
	- completed waiting and canceled waiting
	- average of waiting time
- Error notice
	- when occur error to RC car, show up the error notification 

**App**
 - Call activity
	 - present the stations. and user can select start point, end point by clicking station markers.
     - search recipient with name
	 - order deliver to RC car
 - QR code activity
	 - generate QR code with delivery's information
     - And order next work to RC car (go to destination / end delivery)
  
**Hardware**
 - ROS
	 - Used ROS on Raspberry PI 4(Ubuntu 18.04)
	 - connect Arduino DUE(RC car) with ROS on Raspberry PI 4
 - Make autopilot's algorithm
	 - used RTK-GPS
	 - used azimuth difference between two location
	 - used Lidar to avoid obstacles

	<img src="/reference/car.png" width="300px" height="300px" title="Car" alt="Car"></img><br/>
