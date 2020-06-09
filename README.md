# Project's outline

On a large-scale university campus, or an institution like a government office, it takes a lot of time and trouble to walk when you have to send something from one building to another. Also, the number of accidents caused by delivery vehicles from outside has soared recently.
To solve this problem, we came to plan the autopilot delivery service called "**Baribari**" which allows people to simply send and receive goods without having to move directly with RC car.


# BariBari
### user (APP)
Sender calls a RC car through the app, put somethings to send in RC cars, and order RC cars to deliver to destination.
When the RC car arrives at its destination, the Recipient receive the goods sent to him using QR code.
### manager (WEB)
Managers can check the status of delivery or the status and location of RC car in real time. And also can see statistics of this service or manage stations or RC cars or path. 

# Tech/framework used

- OS: Windows, Ubuntu, AWS
- Back-end: Laravel, Node.JS (Socket.IO), MySQL
- Front-end: Vue.JS, bootstrap, Kakao map API
- App : Android
- Hardware : Raspberry PI 4, Arduino DUE, ROS, RTK-GPS


# the part in charge

**Web** 
- Control page (check the status of this service in real-time)
- Statistics page (see statistics of this service)
- Error notice(when occur the error to RC car)

**App**
 - Call activity(Call and order RC car to deliver)
 - QR code activity ( generate QR code with delivery's information)
  
**Hardware**
 - Use ROS on Raspberry PI 4(Ubuntu 18.04) and connect this with Arduino(RC car)
 - Make autopilot's algorithm(using RTK-GPS and azimuth)
