using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Text.RegularExpressions;

namespace CAP6777_HW02
{
    class Program
    {
        public static List<List<string>> result = new List<List<string>>();
        public static string filecontent = "";
        static void Main(string[] args)
        {
            filecontent = ReadFile("Homework 02 - Figure2.txt");
            AnalyzePage();
            PrintResults();
        }

        public static void AnalyzePage()
        {
            int index = 0;
            do index = FindWrapperBoundries(index); while (index != -1);

        }

        public static int FindWrapperBoundries(int frontindex)
        {
            int backindex = -1;
            frontindex = filecontent.IndexOf("<LI>");
            if (frontindex == -1) return -1;
            filecontent = filecontent.Substring(frontindex, filecontent.Length - frontindex);

            for (int i = 1; i < filecontent.Length - 1; i++)
            {
                if (filecontent[i] == '<')
                {
                    if (filecontent[i + 2] == 'L' && filecontent[i + 3] == 'I' && filecontent[i + 4] == '>')
                    {
                        backindex = i;
                        ExtractData(filecontent.Substring(0, backindex+5));
                        filecontent = filecontent.Substring(i, filecontent.Length - i);
                        return 0;
                    }
                    filecontent = filecontent.Substring(i, filecontent.Length - i);
                    return 0;
                }
            }
            return -1;
        }
       
        public static void ExtractData(string line)
        {
            List<string> row = new List<string>();
            MatchCollection mc;
            mc = Regex.Matches(line, @"(\>\w+\s*\w*\,\s\w+\s*\w*\s*)");
            row.Add(mc[0].ToString().Substring(1, mc[0].ToString().Length - 2));
            mc = Regex.Matches(line, @"(\((.+)\,\s(.+)\))");
            row.Add(mc[0].ToString().Substring(1, mc[0].ToString().Length - 2));
            mc = Regex.Matches(line, @"(\:\s(.+)\s)");
            string pop = mc[0].ToString();
            row.Add(mc[0].ToString().Substring(2, mc[0].ToString().Length - 3));
            result.Add(row);
        }

        public static string ReadFile(string filename)
        {
            string result = "";
            var lines = File.ReadLines(filename);
            foreach (var line in lines)
            {
                result += line;
            }
            return result;
        }

        public static void PrintResults()
        {
            Console.Out.WriteLine("+--------------------------+--------------------------+--------------------------+");
            Console.Out.WriteLine("|  " + PadRight("City, Country", 25) + "|  " + PadRight("Location", 25) + "|  " + PadRight("Population", 25) + "|  ");
            Console.Out.WriteLine("+--------------------------+--------------------------+--------------------------+");
            for (int i = 0; i < result.Count; i++)
            {
                string output = "";
                for(int j = 0; j < result[0].Count; j++)
                {
                    output += PadRight(result[i][j], 25) + "|  ";
                }
                Console.Out.WriteLine("|  " + output);
            }
            Console.Out.WriteLine("+--------------------------+--------------------------+--------------------------+");
            Console.Write("\nPress any key to continue . . . ");
            Console.ReadKey(true);
        }

        public static string PadRight(string input, int length)
        {
            for(int i = 0; i < length; i++)
            {
                if (i > input.Length) input += " ";
            }
            return input;
        }
    }
}
