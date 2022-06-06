a, b, c, d, e, f = input().split()
a = int(a)
b = int(b)
c = int(c)
d = int(d)
e = int(e)
f = int(f)

cont = 0

A, B, C, D, E, F = input().split()
A = int(A)
B = int(B)
C = int(C)
D = int(D)
E = int(E)
F = int(F)
if(a==A or a == B or a==C or a == D or a == E or a == F):
        cont = cont + 1
if(b==A or b == B or b==C or b == D or b == E or b == F):
        cont = cont + 1
if(c==A or c == B or c==C or c == D or c == E or c == F):
        cont = cont + 1        
if(d==A or d == B or d==C or d == D or d == E or d == F):
        cont = cont + 1
if(e==A or e == B or e==C or e == D or e == E or e == F):
        cont = cont + 1        
if(f==A or f == B or f==C or f == D or f == E or f == F):
        cont = cont + 1  
if(cont == 3):
    print("terno")   
elif(cont == 4):
    print("quadra") 
elif(cont == 5):
    print("quina")    
elif(cont == 6):
    print("sena") 
else:
    print("azar")