#!/usr/bin python3
import cv2
import os
import sys

ip_camera = sys.argv[1]
nome = sys.argv[2]
#print(ip_camera)
os.environ["OPENCV_FFMPEG_CAPTURE_OPTIONS"] = "rtsp_transport;0"

#cap = cv2.VideoCapture(r"rtsp://192.168.0.103:554/onvif1")
#print(ip_camera)
cap = cv2.VideoCapture(ip_camera)

for x in range(1,10):
    ret,img=cap.read()
print(ret)
cv2.imwrite("/var/www/html/smile/pics/"+nome, img)

