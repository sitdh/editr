# Editr (อิดิเตอร์)

Web API สำหรับการส่งข้อมูลจากตัวแก้ไขซอร์สโค้ด ไปยังบริการที่ทำหน้าที่คอมไพล์ (Compile) โค้ดต้นฉบับ
และสอบทวนการทำงานของซอร์สโค้ดเทียบกับชุดของกรณีทดสอบ 

## ส่วนประกอบ

1. ส่วนแก้ไขซอร์สโค้ด (Editor)
จะรับค่า หมายเลขรหัสแบบทดสอบ (Assessment Identification) และหมายเลขรหัสคำถาม 
(Question Identification) ใช้สำหรับค้นหาคำถามและแบบทดสอบที่ผู้เรียนต้องใช้ มาจากส่วนจัดการ
ข้อสอบ แล้วจึงส่งข้อมูลของซอร์สโค้ดไปยังคอมไพล์เลอร์ผ่าน `ส่วนเชื่อมต่อกับคอมไพล์เลอร์` เพื่อดูผลลัพธ์
การทำงานเทียบกับกรณีทดสอบ หรือดูผลการทำงานเพื่อหาข้อผิดพลาด

1. ส่วนเชื่อมต่อกับคอมไพล์เลอร์ (Compiler Interface)
ใช้สำหรับเป็นตัวกลางในการเชื่อมต่อกับคอมไพล์เลอร์ มีหน้าที่จัดการข้อมูลที่ต้องส่งไปให้กับคอมไพล์เลอร์
เช่น กรณีทดสอบ และนำผลลัพธ์ที่ได้คืนมาส่งกลับไปให้ยัง `ส่วนแก้ไขซอร์สโค้ด`

1. คอมไพล์เลอร์ (Compiler)
ทำหน้าที่ตรวจสอบความถูกต้องของซอร์สโค้ดด้านไวยากรณ์ของภาษาและการทำงานเมื่อเทียบเคียงกับ
กรณีทดสอบ โดยรับค่าจาก `ส่วนเชื่อมต่อกับคอมไพลเลอร์` เพื่อใช้ในการทำงานการ


## การตั้งค่า

- ส่วนแก้ไขซอร์สโค้ด (Editor)
จะใช้งาน [SDD-editor](https://github.com/guiderof/SDD-editor) ตามขึ้นตอนที่อธิบายไว้ด้านใน


- ส่วนเชื่อมต่อกับคอมไพล์เลอร์ (Compiler Interface)
ใช้งาน [editr](https://github.com/sitdh/editr) โดยมีขั้นตอนการปรับแต่งค่าต่างๆ ดังนี้
  1. ภายในไฟล์ที่ชื่อว่า `bootstrap/app.php` บรรทัดที่ 100 จะพบกับฟังก์ชัน `config` ที่กำหนดค่า
  ต่างๆ ที่ใช้ในการเชื่อมแต่ไว้ เช่น `service.course.testcase` สำหรับดึงข้อมูลของแบบทดสอบพร้อม
  ทั้งรายการคำถาม ซึ่งด้านในจะมีเครื่องหมาย `%s` ในตำแหน่งของหมายเลขแบบทดสอบและคำถาม 
  ตามลำดับ ซึ่งจะต้องแก้ไขในบรรทัดที่ 103 `testcase`, บรรทัดที่ 106 `compile` และ 
  บรรทัดที่ 107 `test` เพื่อชี้ไปยังตำแหน่งของระบบที่ให้ให้ข้อมูล กรณีทดสอบ ตรวจสอบซอร์สโค้ด และ
  ทดสอบซอร์สโค้ด ตามลำดับ

  1. เริ่มต้นการทำงานด้วยคำสั่ง `php -S localhost:8090 -t public/` ณ ตำแหน่งบนสุด
  ในลำดับขั้นโฟลเดอร์ของโปรเจค

- คอมไพล์เลอร์ (Compiler)
จะใช้งาน [SECU-API](https://github.com/sitdh/SECU-API) ในการทำงานเป็นหลัก โดยมีค่าที่
ต้องกำหนดดังนี้
  1. แก้ไขไฟล์ `.env` ด้วยการระบุตำแหน่งและข้อมูลการเข้าใช้งานฐานข้อมูลที่เหมาะสมกับเครื่อง
  ที่ทดสอบ เช่น ชื่อฐานข้อมูล ชื่อผู้ใช้งาน รหัสผ่าน

  1. ใช้คำสั่ง `php artisan make:migration` ณ ตำแหน่งบนสุดของโครงสร้างโฟลเดอร์ของโครงการ

  1. ใช้คำสั่ง `php artisan db:seed` ณ ตำแหน่งเดียวกัน

  1. ใช้คำสั่ง `php -S localhost:80` คำสั่งนี้อาจจะจำเป็นที่จะต้องใช้สิทธิของผู้ดูแลระบบของเครื่อง
  ทดสอบ


## การเชื่อมต่อระหว่างส่วนแก้ไขซอร์สโค้ดและคอมไพล์เลอร์
ดังที่ได้กล่าวมาแล้วว่าการเชื่อมต่อของทั้ง 2 ส่วนนี้จะเชื่อมต่อผ่าน `ส่วนเชื่อมต่อกับคอมไพล์เลอร์` 
ซึ่งคอยทำหน้าที่กันหน้าที่การเชื่อมต่อไม่ให้ปะปนกับส่วนแก้ไขซอร์สโค้ด ซึ่งจะมีการเชื่อมต่ออยู่ทั้งหมด 3 
รายการ ที่ต้องใช้ ดังนี้

### คำถามและแบบทดสอบ
__ตำแหน่ง__: `api/question/{assessment_id}-{question_id}`  
__วิธีการเรียกใช้งาน__: `GET` 
__คำอธิบาย__: ข้อมูลแบบทดสอบและคำถาม โดยที่ `assessment_id` และ `question_id` คือรหัส
ของแบบทดสอบและคำถามตามลำดับ 
__รูปแบบผลลัพธ์__: `{ 'info': { 'id': 2, 'description': '.....' } }`  
  + `id`: รหัสคำถาม  
  + `description`: คำอธิบาย หรือรายละเอียดเกี่ยวกับคำถามชุดนี้
__ตัวอย่างการใช้งาน__: `http://localhost:8090/api/question/1-2`

### ตรวจสอบซอร์สโค้ด 
__ตำแหน่ง__: `api/question/compile`  
__วิธีการเรียกใช้งาน__: `POST`  
__คำอธิบาย__: เป็นการตรวจสอบซอร์สโค้ดที่ได้พัฒนานาขึ้นว่ามีข้อผิดพลาดใดเกิดขึ้นหรือไม่ ทั้งนี้จำเป็นต้อง
ส่งซอร์สโค้ดที่พัฒนาขึ้นมานี้มาในตัวแปร `script`   
__รูปแบบผลลัพธ์__: `{ 'compiled': { 'results': true } }`  
  + `results`: ผลลัพธ์การทำงาน จริง/เท็จ  
__ตัวอย่างการใช้งาน__: `curl -X POST -d "script=print "hello, world"' http://localhost:8090/api/question/compile`  

### ตรวจสอบซอร์สโค้ดเทียบกับกรณีทดสอบ
__ตำแหน่ง__: `api/question/test/{assessment_id}-{question_id}`  
__วิธีการเรียกใช้งาน__: `POST`  
__คำอธิบาย__: เป็นการตรวจสอบซอร์สโค้ดที่ได้พัฒนานาขึ้นว่ามีข้อผิดพลาดใดเกิดขึ้นหรือไม่ ทั้งนี้จำเป็นต้อง
ส่งซอร์สโค้ดที่พัฒนาขึ้นมานี้มาในตัวแปร `script` และกำหนดรูปแบบของ URL ตามรหัสแบบทดสอบและ
คำถามตามลำดับ  
__รูปแบบผลลัพธ์__: `{"tested":{"results":[false,false,false,false]}}`  
  + `results`: ผลลัพธ์การทำงาน จริง/เท็จ เมื่อเทียบกับกรณีทดสอบที่มี (จำนวนจะขึ้นอยู่กับรายการของกรณีที่สอบที่กำหนดไว้)
__ตัวอย่างการใช้งาน__: `curl -X POST -d "script=print "hello, world"' http://localhost:8090/api/question/test/1-2`  

