from setuptools import setup, find_packages
 
setup(
    name='opaque',
    version=__import__('opaque').__version__,
    description='Obfuscation scheme for integer IDs',
    author='Marek Z.',
    url='http://github.com/marekweb/opaque-id',
    packages=find_packages(),
    classifiers=[
        'Development Status :: 3 - Alpha',
        'Environment :: Web Environment',
        'Intended Audience :: Developers',
        'License :: OSI Approved :: MIT License',
        'Operating System :: OS Independent',
        'Programming Language :: Python',
    ],
    include_package_data=True,
    zip_safe=False,
)