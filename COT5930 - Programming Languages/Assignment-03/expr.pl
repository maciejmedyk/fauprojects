
use strict;

while( <> )                         # <> one line at a time into $_
{
    chomp;                          # same a chomp( $_ ); remove \n
    print "input line:\t$_\n";      # print current line

    my ( @a ) = tokens( $_ );       # break current line into tokens

    pstack( "tokens:", \@a );       # title and address of array a

#   postfix( @a );


    print "\n";
}


sub pstack
{
    my $title = $_[ 0 ];            # first  parameter: a scalar
    my $stack = $_[ 1 ];            # second parameter: addr. of a stack
    my %inputOpPrec = ( '(' => 99, '+' => 4, '-' => 5, '*' => 9, '/' => 10);
    my %stackOpPrec = ( '(' => 00, '+' => 6, '-' => 7, '*' => 11, '/' => 12);
    my $input;
    my @pStack;
    my $state = 0;
    my @stack;
    my ( $i );

    print "\n$title\n";

    if( @$stack <= 0 )              # is the stack empty?
    {
        print "\tnone\n";
    }
    else
    {                               # treat $stack as an array
        for( $i = 0; $i < @$stack; ++$i )
        {
            print "$i\t$$stack[ $i ]\n";
        }
    }

    print "\noutput : ";

    for(my $i = 0 ; $i < @$stack; $i++)
    {
        $input = $$stack[$i];

        if($input eq '(' && ($state == 0 || $state == 2) )
        {
            $state = 2;
            push @pStack, '(';
            push @stack , '(';
        }
        elsif ($input eq ')' && ($state == 1 || $state == 2))
        {
            $state = 1;
            unless (defined $pStack[$#pStack] && $pStack[$#pStack] eq '(')
            {

            }
            else
            {
               delete $pStack[$#pStack]; 
            }
            for(my $j = $#stack; $j >= 0; $j--)
            {
                if ($stack[$j] eq '(') 
                {
                    delete $stack[$j];
                    last;
                }
                else
                {
                  print delete $stack[$j]; print " ";
                }
            }
        }
        elsif (exists $inputOpPrec{$input} && $state == 1)
        {
            $state = 0;
            if(scalar(@stack) == 0 )
            {
                push @stack, $input;
            }
            else
            {
                for(my $j = $#stack; $j >= 0; $j--)
                {
                    my $stackSymbol = $stack[$j];
                    if( $stackOpPrec{$stackSymbol} > $inputOpPrec{$input} )
                    {
                        print delete $stack[$j]; print " ";
                    }
                    else
                    {
                        last;
                    }
                }
                push @stack, $input;
            }
        }
        elsif($input =~ /(?:^(-|)\d+$|\w+$)/ && ($state == 0 || $state == 2))
        {
            $state = 1;
            print "$input ";
        }
    }
    for(my $j = $#stack; $j >= 0; $j--)
    {
        print $stack[$j]." ";
    }
    print "\n";
}


sub tokens
{
    local $_ = $_[ 0 ];             # first parameter in @_

    my ( @tok ) = split( /\s+/ );   # split $_ on white spaces

    return @tok;
}

