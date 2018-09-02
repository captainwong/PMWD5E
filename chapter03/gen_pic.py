
from PIL import Image, ImageDraw, ImageFont

pics = ['tire.jpg', 'oil.jpg', 'spark_plug.jpg', 
                    'door.jpg', 'steering_wheel.jpg', 
                    'thermostat.jpg', 'wiper_blade.jpg',
                    'gasket.jpg', 'brake_pad.jpg']

def gen_pic(pics):
    for pic in pics:
        img = Image.new('RGB', (600, 600), 'white')
        font = ImageFont.truetype('C:/windows/fonts/Arial.ttf', 64)
        d = ImageDraw.Draw(img)
        d.text((10,10), pic, font=font, fill=(128,128,128))
        img.save(pic)
    print('done')


if __name__ == '__main__':
    gen_pic(pics)