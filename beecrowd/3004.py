n = int(input())
while (n>0) :
    a, b, c, d= input().split()
    a = int(a)
    b = int(b)
    c = int(c)
    d = int(d)
    if ((a < c and b < d) or (b < c and a < d)):
        print("S")
    else :
        print("N")
    n=n-1